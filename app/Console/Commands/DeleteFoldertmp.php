<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
class DeleteFoldertmp extends Command{
    protected $signature = 'command:delete-foldertmp';
    protected $description = 'Eliminar la carpeta temporal que guarda imágenes';
    public function handle() {
        File::deleteDirectory(storage_path('app/public/livewire-tmp'));
    }
}
