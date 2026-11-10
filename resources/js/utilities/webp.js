import fs from "fs/promises";
import path from "path";
import sharp from "sharp";

const SOURCE_PATTERN = /\.(jpg|png)$/;

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

    await sharp(sourcePath)
        .webp({ quality: 90, effort: 4 })
        .toFile(destinationPath);

    return true;
};

const convertImages = async (sourceDir) => {
    try {
        const entries = await fs.readdir(sourceDir, { withFileTypes: true });
        const files = entries
            .filter(
                (entry) => entry.isFile() && SOURCE_PATTERN.test(entry.name),
            )
            .map((entry) => path.join(sourceDir, entry.name));

        const results = await Promise.allSettled(files.map(convertImage));

        results.forEach((result, index) => {
            if (result.status === "rejected") {
                console.error(
                    `❌  Error converting ${files[index]}`,
                    result.reason,
                );
            }
        });

        const converted = results.filter(
            (result) => result.status === "fulfilled" && result.value,
        ).length;

        console.log(
            `✅  Images Converted Successfully in ${sourceDir} (${converted} converted, ${files.length - converted} unchanged)`,
        );
    } catch (error) {
        console.error(`❌  Error converting images in ${sourceDir}`, error);
    }
};

const getDirectories = async (sourceDir) => {
    try {
        const entries = await fs.readdir(sourceDir, { withFileTypes: true });
        return entries
            .filter((entry) => entry.isDirectory())
            .map((entry) => path.join(sourceDir, entry.name));
    } catch (error) {
        console.error(`❌  Error reading directories in ${sourceDir}`, error);
        return [];
    }
};

const processDirectories = async () => {
    const baseDir = "./resources/images";

    await convertImages(baseDir);

    const directories = await getDirectories(baseDir);

    for (const dir of directories) {
        await convertImages(dir);
    }
};

processDirectories()
    .then(() => {
        console.log("✅  Images Converted Successfully!");
    })
    .catch((error) => {
        console.error("❌  Error processing directories:", error);
    });
