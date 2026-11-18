/**
 * PWA and favicon: icons of the manifest and of <x-frontend::pwa />, with the right sizes and
 * replaced by the project's own (the starter ones are placeholders)
 */
import { createHash } from "crypto";
import { existsSync, readFileSync } from "fs";
import sharp from "sharp";
import { createResult, statusOf } from "./results.js";

const item = "PWA e favicon";

const iconsFolder = "resources/images/icons";

// Icons linked by <x-frontend::pwa /> (pwa.blade.php), besides the manifest ones
const linkedIcons = [
    { file: "apple-touch-icon.png", sizes: "180x180" },
    { file: "favicon.ico", sizes: null },
    { file: "safari-pinned-tab.svg", sizes: null },
];

// sha256 of the starter's placeholder icons: a project ships its own
const starterIconHashes = new Set([
    "4b7abda9b3b0a50c54ef48560c4fcca74fff700b313184ca07d74ac215ecbd17", // apple-touch-icon.png
    "869536d62b2eba86b6e2828c34134fe1aa7f0f6e8a3545eae3f314e98257200f", // apple-touch-icon.webp
    "eb8876a87a075a589e15204d2ce165aeb4332219f20d5216bb9e157278e64092", // favicon.ico
    "b18cb38b90abd120cfd7589f48534aa863ad7645d48b964c1643ccfbf866fc96", // icon-192x192.png
    "5bcac2be1dbdc3a143eff3845e2a95a3bae6403f7ddcf81c4418579dc4d9eadd", // icon-192x192.webp
    "b8d5207e10c69f0a622172f085a3298e534aebc843080d5aa93c22ac0a996a94", // icon-512x512.png
    "d055d1d4063741b68a993eaf5f8ebd5b4194651bd3173db374c8fc3323f03a1f", // icon-512x512.webp
    "fa43129a517880b402a1e48d64c75d4ef02076fd4a4c6996d6a70f6b7d8f0a19", // mstile-150x150.png
    "4dbefbb8bdcb5f820097e74e0c37f4da32207e0ccd1f691bff741bc4c397bfe7", // mstile-150x150.webp
    "0653b8fd2c1b8ac780ec724a177f5bb24cf546517f7959a4e8db026c88bfb31f", // safari-pinned-tab.svg
]);

// Name of the app in create-manifest.js while it's still the starter's
const starterAppName = "Starter";

// First bytes of a .ico file
const icoSignature = Buffer.from([0, 0, 1, 0]);

const hashOf = (buffer) => createHash("sha256").update(buffer).digest("hex");

async function sizeOf(buffer) {
    const { width, height } = await sharp(buffer).metadata();

    return `${width}x${height}`;
}

/**
 * Checks one icon: size (when known), placeholder of the starter. Returns the problems
 */
async function checkIcon(label, buffer, expectedSizes) {
    const problems = { fails: [], warnings: [] };

    if (buffer.length === 0) {
        problems.fails.push(`${label}: arquivo vazio`);

        return problems;
    }

    if (label.endsWith(".ico")) {
        if (!buffer.subarray(0, 4).equals(icoSignature)) {
            problems.fails.push(`${label}: não é um arquivo .ico`);
        }
    } else if (expectedSizes) {
        const realSizes = await sizeOf(buffer);

        if (realSizes !== expectedSizes) {
            problems.fails.push(
                `${label}: tem ${realSizes}, esperado ${expectedSizes}`,
            );
        }
    }

    if (starterIconHashes.has(hashOf(buffer))) {
        problems.warnings.push(`${label}: ainda é o ícone do starter`);
    }

    return problems;
}

function toResult(target, { fails, warnings }) {
    return createResult(item, target, statusOf(fails, warnings), [
        ...fails,
        ...warnings,
    ]);
}

async function checkManifest(baseUrl) {
    const manifestFile = "public/manifest.json";
    const problems = { fails: [], warnings: [] };

    if (!existsSync(manifestFile)) {
        problems.fails.push(`${manifestFile} não existe: rode \`npm run pwa\``);

        return toResult(manifestFile, problems);
    }

    const manifest = JSON.parse(readFileSync(manifestFile, "utf8"));

    if (
        manifest.name === starterAppName ||
        manifest.short_name === starterAppName
    ) {
        problems.warnings.push(
            `name/short_name ainda é "${starterAppName}": ajuste o \`app\` em resources/js/utilities/create-manifest.js`,
        );
    }

    for (const { src, sizes } of manifest.icons ?? []) {
        const response = await fetch(`${baseUrl}/${src}`);

        if (response.status !== 200) {
            problems.fails.push(`${src}: respondeu ${response.status}`);
            await response.body?.cancel();
            continue;
        }

        const iconProblems = await checkIcon(
            src.split("/").pop(),
            Buffer.from(await response.arrayBuffer()),
            sizes,
        );

        problems.fails.push(...iconProblems.fails);
        problems.warnings.push(...iconProblems.warnings);
    }

    return toResult(manifestFile, problems);
}

async function checkLinkedIcons() {
    const problems = { fails: [], warnings: [] };

    for (const { file, sizes } of linkedIcons) {
        const path = `${iconsFolder}/${file}`;

        if (!existsSync(path)) {
            problems.fails.push(`${path}: não existe`);
            continue;
        }

        const iconProblems = await checkIcon(file, readFileSync(path), sizes);

        problems.fails.push(...iconProblems.fails);
        problems.warnings.push(...iconProblems.warnings);
    }

    return toResult(`${iconsFolder} (pwa.blade.php)`, problems);
}

/**
 * Browsers ask for /favicon.ico on their own (pdf, images opened directly): public/favicon.ico
 * must be the project's favicon too
 */
async function checkRootFavicon(baseUrl) {
    const target = "/favicon.ico";
    const response = await fetch(`${baseUrl}${target}`);

    if (response.status !== 200) {
        await response.body?.cancel();

        return createResult(item, target, "fail", [
            `respondeu ${response.status}`,
        ]);
    }

    const buffer = Buffer.from(await response.arrayBuffer());
    const problems = await checkIcon("public/favicon.ico", buffer, null);

    const projectFavicon = `${iconsFolder}/favicon.ico`;

    if (
        buffer.length > 0 &&
        existsSync(projectFavicon) &&
        hashOf(buffer) !== hashOf(readFileSync(projectFavicon))
    ) {
        problems.warnings.push(
            `public/favicon.ico é diferente de ${projectFavicon}`,
        );
    }

    return toResult(target, problems);
}

export default async function checkPwa({ baseUrl }) {
    return [
        await checkManifest(baseUrl),
        await checkLinkedIcons(),
        await checkRootFavicon(baseUrl),
    ];
}
