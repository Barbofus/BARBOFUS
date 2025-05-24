import fs from 'fs';
import {PNG} from 'pngjs';
import {kmeans} from 'ml-kmeans'


const alphaThreshold = 160;

async function getVisiblePixels(imagePath) {
  try {
    await fs.promises.access(imagePath);
  } catch (err) {
    throw new Error(`File not found: ${imagePath}`);
  }
  return new Promise((resolve, reject) => {
    fs.createReadStream(imagePath)
      .pipe(new PNG())
      .on('parsed', function () {
        const validPixels = [];
        for (let y = 0; y < this.height; y++) {
          for (let x = 0; x < this.width; x++) {
            const idx = (this.width * y + x) << 2;
            const r = this.data[idx];
            const g = this.data[idx + 1];
            const b = this.data[idx + 2];
            const a = this.data[idx + 3];

            if (a > alphaThreshold) {
              validPixels.push([r, g, b]);
            }
          }
        }
        resolve(validPixels);
      })
      .on('error', reject)
  })
}

async function getTopColors(imagePath) {
  const pixels = await getVisiblePixels(imagePath)
  if (pixels.length === 0) throw new Error()
  let result = kmeans(pixels, 3)

  let filterResult = [0, 0, 0]
  for (const pixel of pixels) {
    const d0 = result.distance(pixel, result.centroids[0])
    const d1 = result.distance(pixel, result.centroids[1])
    const d2 = result.distance(pixel, result.centroids?.[2] ?? [0, 0, 0])
    if (d0 < d1 && d0 < d2) {
      filterResult[0]++
    } else if (d1 < d0 && d1 < d2) {
      filterResult[1]++
    } else {
      filterResult[2]++
    }
  }

  /*let filterResultPercent = filterResult.map(v => v / pixels.length)

  if (filterResultPercent.some(v => v < 0.10)) {
    result = kmeans(pixels, 2)
  }

  return result.centroids.map((c, i) => {
      return c.map(v => Math.round(v).toString(16).padStart(2, '0')).join('')
  })*/

    return result.centroids.map((c, i) => {
        return c.slice(0, 3) // garde uniquement R, G, B
            .map(v => Math.round(v).toString(16).padStart(2, '0')  ?? null)
            .join('');
    });
}

async function getColorivant(item) {
  if (item.indexedColors && item.indexedColors.length > 0) {
    return false
  }
  let pathFiles = []
  if (item.folder === 'skins') {
    pathFiles = [
      `${appPath}\\json\\skinator\\skins\\${item.sprite[0]}.json`,
    ]
  } else if (item.folder === 'bones') {
    pathFiles = [
      `${appPath}\\json\\skinator\\bones\\Bones_AssetData\\${item.sprite[0]}.json`,
    ]
  }
  const files = pathFiles.map(p => fs.promises.readFile(p))
  for await (const file of files) {
    const text = await file.toString('utf-8')
    const hasColorHray = text.includes('ColorGray_')
    if (hasColorHray) {
      return true
    }
  }
  return false
}

const args = process.argv.slice(2); // Ignorer "node" et le nom du fichier
const [JSON_ITEM_PATH, kolorsIdTxt, appPath] = args;
//const JSON_ITEM_PATH = 'C:\\Users\\jonat\\Desktop\\DofusSkin\\Data\\itemsExport.json';

function getIdsFromFileSync(filePath) {
    try {
        const data = fs.readFileSync(filePath, 'utf8');
        return data
            .split('\n')
            .map(line => line.trim())
            .filter(line => line);
    } catch (err) {
        console.error('Erreur de lecture du fichier:', err);
        return [];
    }
}

async function main() {
    const items = JSON.parse(fs.readFileSync(JSON_ITEM_PATH, 'utf8'));
    const desiredIds = getIdsFromFileSync(kolorsIdTxt);
    const allIds = Object.keys(items);
    const ouputData = []
    for (let count = 0; count < allIds.length; count++) {
    const itemId = allIds[count];
    const item = items[itemId];

    if(!desiredIds.includes(itemId)) {
        console.log('ANNULATION', itemId);
        continue;
    }

    const folder = item.folder;
    const skinId = item.sprite[0];

    if (!skinId) {
      continue
    }

    try {
        const imagePath = `${appPath}\\public\\images\\skinator\\${folder}\\${skinId}.png`;
        const isColorivant = await getColorivant(item);

        let topColor = []
        if (item.indexedColors && item.indexedColors.length > 0) {
            topColor = item.indexedColors.map(v => Number(v).toString(16).padStart(6, '0') )
        } else if (!isColorivant) {
            topColor = await getTopColors(imagePath);
        }

        items[itemId].kolors = topColor;
        items[itemId].colorivant = isColorivant;
    } catch (error) {
        console.error(`Error processing item ID ${itemId} [${skinId}]:`, error.message);
    }

    }

    fs.writeFileSync(`${appPath}\\json\\skinator\\itemsExport.json`, JSON.stringify(items, null, 2), 'utf8');
}
main();
