<?php
use Illuminate\Support\Facades\File;

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


# nt: modificar depois feito as pressas
/**
 * Comando personalizado para criar uma classe de service.
 * Arquivo criado no diretorio /app/Service/ + nome do model
 */
Artisan::command('make:service {model} {name}', function (string $model, string $name){
    $model = ucfirst(strtolower($model));
    $name = ucfirst(strtolower($name));

    $models = collect(File::files(app_path('Models')))->map(function ($file) {
        return ucfirst(strtolower($file->getBasename('.php')));
    });

    if ( !$models->contains($model) ){
        $this->error('Erro ao criar service -> Model: '. $model .' não existe');
        return;
    }

    $dirpath = app_path() . '/Services/' . $model;
    $filepath = $dirpath . '/' . $name . $model . 'Service.php';

    if ( File::isFile($filepath) ){
        $this->error('Erro ao criar service -> Service ja existe'); 
        return;
    }

    if ( !File::isDirectory($dirpath) ){
        File::makeDirectory($dirpath, 0755, true, true);
    }

    File::put($filepath, 
        "<?php\n\n" .
        "namespace App\Services\\" . $model . ";\n\n" .
        "use App\Models\\" . $model . ";\n\n" . 
        "class " . $name . $model . "Service\n {\n" .
        "\tpublic static function execute( array \$data )\n\t{\n\t\t//\n\t}\n}"
    );

    $this->info('Service Criado com sucesso');
})->purpose('Cria um service. requer dois parametros o nome do model e o nome do Service de fato');
