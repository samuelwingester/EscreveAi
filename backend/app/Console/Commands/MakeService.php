<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

#[Signature( 'make:service { --m|model= } { name } ' )]
#[Description(' Create a new service classCommand description' )]
class MakeService extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument( 'name' );
        $model = $this->getModel();         

        $dirPath = $this->getDirPath( $name, $model );
        $filePath = $dirPath . Str::finish( Str::afterLast( $name, '/' ), '.php' );

        if ( File::isFile( $filePath ) ){
            $this->error('Erro ao criar service -> Service ja existe'); 
            return;
        }

        if ( !File::isDirectory( $dirPath ) )
            File::makeDirectory( $dirPath, 0755, true, true );

        File::put( $filePath, $this->getFileContent( $name, $model ) );

        $this->info( 'Service Criado com sucesso em ' . $filePath );
    }

    private function getModel(): mixed
    {
        if ( $this->option( 'model' ) == null )
            return null;

        $model = ucfirst( strtolower( $this->option( 'model' ) ) );

        $models = collect( File::files( app_path( 'Models' ) ) )->map( function ( $file ) {
            return ucfirst( strtolower( $file->getBasename('.php') ) );
        });

        if ( !$models->contains( $model ) )
            return null;
        
        return $model;
    }

    private function getDirPath( string $name, mixed $model ): string
    {
        if ( $model == null )
            return Str::finish( app_path() . '/Http/Services' . Str::beforeLast( Str::start( $name, '/' ), '/' ), '/' );
        return Str::finish( app_path() . '/Http/Services/' . $model, '/' ); 
    }

    private function getFileContent( string $name, mixed $model ): string
    {
        $content = "<?php\n\nnamespace App\\Http\\Services\\";
        
        if ( $model == null ){
            $content = $content . Str::replace( '/' , '\\', Str::beforeLast( $name, '/' ) ) . ";\n\n"; 
        }
        else {
            $content = $content . $model . "\\" . Str::replace( '/' , '\\', Str::beforeLast( $name, '/' ) ) . ";\n\n"; 
            $content = $content . "use App\\Models\\" . $model . ";\n\n";
        }

        $content = $content . "class " . $name . "\n{\n";
        $content = $content . "\tpublic function execute( array \$data )\n\t{\n\t\t//\n\t}\n}";

        return $content;
    }
}
