/**
 * WebP copies of the images: every .jpg/.png of resources/images gets a .webp next to it, read by
 * <x-frontend::picture> (<source type="image/webp">).
 *
 * Runs before `npm run dev` and `npm run build` (or alone with `npm run webp`). An image whose .webp
 * is newer than it is skipped, so only new or changed images are converted.
 */
import fs from "fs/promises";
import path from "path";
import sharp from "sharp";

// =============================================================================================
// PROJECT SETTINGS: adjust them for each project
// =============================================================================================

// Folder of the images: its files and its direct subfolders are converted (one level deep)
const imagesFolder = "./resources/images";

// Files converted to webp
const sourcePattern = /\.(jpg|png)$/;

// sharp options: quality (0–100) and effort (0–6, slower gives a smaller file)
const webpOptions = { quality: 90, effort: 4 };

// =============================================================================================
// BUILD INFRASTRUCTURE: no need to change it
// =============================================================================================

const getWebpPath = (filePath) => {
    const { dir, name } = path.parse(filePath);

    return path.join(dir, `${name}.webp`);
};

const isUpToDate = async (sourcePath, destinationPath) => {
    try {
        const [source, destination] = await Promise.all([
            fs.stat(sourcePath),
            fs.stat(destinationPath),
        ]);

        return destination.mtimeMs >= source.mtimeMs;
    } catch {
        return false;
    }
};

const convertImage = async (sourcePath) => {
    const destinationPath = getWebpPath(sourcePath);

    if (await isUpToDate(sourcePath, destinationPath)) {
        return false;
    }

    await sharp(sourcePath).webp(webpOptions).toFile(destinationPath);

    return true;
};

const convertImages = async (sourceDir) => {
    try {
        const entries = await fs.readdir(sourceDir, { withFileTypes: true });
        const files = entries
            .filter((entry) => entry.isFile() && sourcePattern.test(entry.name))
            .map((entry) => path.join(sourceDir, entry.name));

        const results = await Promise.allSettled(files.map(convertImage));

        results.forEach((result, index) => {
            if (result.status === "rejected") {
                console.error(
                    `\x1b[31m✗\x1b[0m Error converting ${files[index]}`,
                    result.reason,
                );
            }
        });

        const converted = results.filter(
            (result) => result.status === "fulfilled" && result.value,
        ).length;

        console.log(
            `\x1b[32m✓\x1b[0m Images Converted Successfully in ${sourceDir} (${converted} converted, ${files.length - converted} unchanged)`,
        );
    } catch (error) {
        console.error(
            `\x1b[31m✗\x1b[0m Error converting images in ${sourceDir}`,
            error,
        );
    }
};

const getDirectories = async (sourceDir) => {
    try {
        const entries = await fs.readdir(sourceDir, { withFileTypes: true });
        return entries
            .filter((entry) => entry.isDirectory())
            .map((entry) => path.join(sourceDir, entry.name));
    } catch (error) {
        console.error(
            `\x1b[31m✗\x1b[0m Error reading directories in ${sourceDir}`,
            error,
        );
        return [];
    }
};

const processDirectories = async () => {
    await convertImages(imagesFolder);

    const directories = await getDirectories(imagesFolder);

    for (const dir of directories) {
        await convertImages(dir);
    }
};

processDirectories()
    .then(() => {
        console.log("\x1b[32m✓\x1b[0m Images Converted Successfully!");
    })
    .catch((error) => {
        console.error("\x1b[31m✗\x1b[0m Error processing directories:", error);
    });
