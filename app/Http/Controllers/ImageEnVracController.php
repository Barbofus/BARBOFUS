<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;

class ImageEnVracController extends Controller
{
    /**
     * @var array<int, string[]>
     */
    public array $images = [];

    public function index(): View
    {
        $this->getAllImages();

        return view('image-en-vrac', [
            'images' => $this->images,
        ]);
    }

    protected function getAllImages(): void
    {
        $files = Storage::disk('public')->files('images/imagenvrac');

        arsort($files);
        $files = array_values($files);

        for ($i = 0; $i < count($files); $i++) {

            $explodeSlash = explode('/', $files[$i]);
            $nameWithDate = $explodeSlash[count($explodeSlash) - 1];

            $explodeDate = explode('_n_', $nameWithDate);

            $name = $explodeDate[count($explodeDate) - 1];

            $finaleName = str_replace('_', ' ', $name);

            $this->images[] = [
                'name' => $finaleName,
                'path' => $files[$i],
            ];
        }
    }

    public function upload(Request $request): RedirectResponse
    {
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $key => $file) {
                if ($file->isValid()) {

                    if ($request->all()['name']) { // Si on a mis un nom custom, on le choisi
                        $finaleName = str_replace(' ', '_', $request->all()['name']);
                    } else { // Sinon on garde le nom original du fichier
                        $finaleName = str_replace(' ', '_', $file->getClientOriginalName());
                    }

                    // Nomme l'image en fonction de l'heure actuelle
                    $imageName = time().$key.'_n_'.$finaleName.'.'.$file->getClientOriginalExtension();

                    // On range ça dans le public
                    $destinationPath = storage_path('app/public/images/imagenvrac');

                    // Créationd de l'image avec Intervention Image
                    $img = Image::make($file->getRealPath());

                    // On resize suivant la taille désiré
                    $img->save($destinationPath.'/'.$imageName);
                }
            }

            return redirect()->back()->with('message', 'Image(s) ajoutée(s) avec succé.');
        }

        return redirect()->back();
    }
}
