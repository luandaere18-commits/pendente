<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$c = App\Models\Curso::orderBy('id', 'desc')->first();
echo "id={$c->id}\n";
$rows = Illuminate\Support\Facades\DB::table('centro_curso')->where('curso_id', $c->id)->get()->toArray();
var_dump($rows);
