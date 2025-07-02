<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Berita;

class DeleteDummyBerita extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'berita:delete-dummy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menghapus semua berita dummy dengan judul "Berita Dummy ke-"';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $deleted = Berita::where('judul', 'like', 'Berita Dummy ke-%')->delete();
        $this->info("Berhasil menghapus $deleted berita dummy.");
    }
}