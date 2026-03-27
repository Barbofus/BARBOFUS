const sharp = require('sharp');
const fs = require('fs');
const path = require('path');
const crypto = require('crypto');

const rootDir = path.join(__dirname, '..', 'storage', 'app', 'public', 'images', 'skinator');
const folderToConvert = [
    { input: path.join(rootDir, 'skins'), output: path.join(rootDir, 'skins_webp') },
    { input: path.join(rootDir, 'bones'), output: path.join(rootDir, 'bones_webp') },
]

const filenameImagesCache = 'imagesCache.json'

const hashFile = (filePath) => {
    return new Promise((resolve, reject) => {
        const hash = crypto.createHash('sha256');
        const stream = fs.createReadStream(filePath);
        stream.on('data', (data) => hash.update(data));
        stream.on('end', () => resolve(hash.digest('hex')));
        stream.on('error', (err) => reject(err));
    });
}

const getImagesCache = async (rootPath) => {
    const cachePath = path.join(rootPath, filenameImagesCache);
    if (fs.existsSync(cachePath)) {
        try {
            const data = await fs.promises.readFile(cachePath, 'utf-8');
            return JSON.parse(data);
        }
        catch (error) {
            console.error('Erreur lors de la lecture du cache des images :', error);
            return {};
        }
    } else {
        return {};
    }
}

const saveImagesCache = async (rootPath, cache) => {
    const cachePath = path.join(rootPath, filenameImagesCache);
    try {
        await fs.promises.writeFile(cachePath, JSON.stringify(cache, null, 2), 'utf-8');
    }
    catch (error) {
        console.error('Erreur lors de la sauvegarde du cache des images :', error);
    }
}


;;;(async () => {

    let debug = 10
    
    for (const { input, output } of folderToConvert) {
        console.log(`Traitement du dossier : ${input}`);
        const files = await fs.promises.readdir(input);
        if (!fs.existsSync(output)) {
            await fs.promises.mkdir(output, { recursive: true });
        }
        const imagesCache = await getImagesCache(output);
        let currentFile = 0;
        for (const file of files) {
            currentFile++;
            process.stdout.write(`\rProgression : ${currentFile}/${files.length} fichiers traités.`);

            if (!file.endsWith('.png')) {
                continue;
            }

            const inputFilePath = path.join(input, file);
            const outputFilePath = path.join(output, file.replace(/\.[^/.]+$/, '.webp'));
            const fileHash = await hashFile(inputFilePath);


            if (imagesCache[file] === fileHash && fs.existsSync(outputFilePath)) {
                continue; 
            }
            try {
                process.stdout.write(`\rConversion de ${file}... `);
                await sharp(inputFilePath)
                    .webp({ quality: 90 })
                    .toFile(outputFilePath);
                imagesCache[file] = fileHash;
            } catch (error) {
                console.error(`Erreur lors de la conversion de ${inputFilePath} :`, error);
            }
            
        }
        console.log(`\nTraitement terminé pour le dossier : ${input}\n\n`);
        await saveImagesCache(output, imagesCache);
    }
})();;;