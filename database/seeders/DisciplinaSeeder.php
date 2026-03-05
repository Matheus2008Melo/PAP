<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Disciplina;

class DisciplinaSeeder extends Seeder
{
    public function run(): void
    {
        $disciplinas = [
            ['nome' => 'Português', 'slug' => 'portugues', 'abreviatura' => 'PT', 'icone' => 'fa-book', 'cor' => '#EF4444'],
            ['nome' => 'Matemática A', 'slug' => 'matematica-a', 'abreviatura' => 'MAT A', 'icone' => 'fa-calculator', 'cor' => '#3B82F6'],
            ['nome' => 'Matemática B', 'slug' => 'matematica-b', 'abreviatura' => 'MAT B', 'icone' => 'fa-chart-line', 'cor' => '#3B82F6'],
            ['nome' => 'Biologia', 'slug' => 'biologia', 'abreviatura' => 'BIO', 'icone' => 'fa-dna', 'cor' => '#10B981'],
            ['nome' => 'Psicologia', 'slug' => 'psicologia', 'abreviatura' => 'PSIC', 'icone' => 'fa-brain', 'cor' => '#8B5CF6'],
            ['nome' => 'Programação de Sistemas Informáticos', 'slug' => 'programacao-si', 'abreviatura' => 'PSI', 'icone' => 'fa-code', 'cor' => '#F59E0B'],
            ['nome' => 'Arquitetura de Computadores', 'slug' => 'arquitetura-computadores', 'abreviatura' => 'AC', 'icone' => 'fa-microchip', 'cor' => '#6366F1'],
            ['nome' => 'Redes de Comunicação', 'slug' => 'redes-comunicacao', 'abreviatura' => 'RC', 'icone' => 'fa-network-wired', 'cor' => '#06B6D4'],
            ['nome' => 'Cidadania', 'slug' => 'cidadania', 'abreviatura' => 'CID', 'icone' => 'fa-users', 'cor' => '#EC4899'],
            ['nome' => 'Inglês', 'slug' => 'ingles', 'abreviatura' => 'ING', 'icone' => 'fa-language', 'cor' => '#84CC16'],
            ['nome' => 'Francês', 'slug' => 'frances', 'abreviatura' => 'FR', 'icone' => 'fa-language', 'cor' => '#F97316'],
            ['nome' => 'Espanhol', 'slug' => 'espanhol', 'abreviatura' => 'ESP', 'icone' => 'fa-language', 'cor' => '#DC2626'],
            ['nome' => 'Ciências Naturais', 'slug' => 'ciencias-naturais', 'abreviatura' => 'CN', 'icone' => 'fa-flask', 'cor' => '#059669'],
            ['nome' => 'Economia', 'slug' => 'economia', 'abreviatura' => 'ECON', 'icone' => 'fa-chart-bar', 'cor' => '#7C3AED'],
            ['nome' => 'Geografia', 'slug' => 'geografia', 'abreviatura' => 'GEO', 'icone' => 'fa-globe-europe', 'cor' => '#065F46'],
            ['nome' => 'Artes', 'slug' => 'artes', 'abreviatura' => 'ART', 'icone' => 'fa-palette', 'cor' => '#E11D48'],
            ['nome' => 'Geometria Descritiva', 'slug' => 'geometria-descritiva', 'abreviatura' => 'GD', 'icone' => 'fa-draw-polygon', 'cor' => '#7DD3FC'],
            ['nome' => 'Filosofia', 'slug' => 'filosofia', 'abreviatura' => 'FIL', 'icone' => 'fa-question', 'cor' => '#A855F7'],
            ['nome' => 'História', 'slug' => 'historia', 'abreviatura' => 'HIST', 'icone' => 'fa-monument', 'cor' => '#CA8A04'],
            ['nome' => 'História e Cultura das Artes', 'slug' => 'historia-cultura-artes', 'abreviatura' => 'HCA', 'icone' => 'fa-landmark', 'cor' => '#DB2777'],
            ['nome' => 'TIC', 'slug' => 'tic', 'abreviatura' => 'TIC', 'icone' => 'fa-computer', 'cor' => '#0EA5E9'],
            ['nome' => 'Área de Integração', 'slug' => 'area-integracao', 'abreviatura' => 'AI', 'icone' => 'fa-puzzle-piece', 'cor' => '#F472B6'],
            ['nome' => 'Sistemas Operativos', 'slug' => 'sistemas-operativos', 'abreviatura' => 'SO', 'icone' => 'fa-desktop', 'cor' => '#1D4ED8'],
            ['nome' => 'Educação Física', 'slug' => 'educacao-fisica', 'abreviatura' => 'EF', 'icone' => 'fa-running', 'cor' => '#DC2626'],
        ];

        foreach ($disciplinas as $index => $disciplina) {
            Disciplina::updateOrCreate(
                ['slug' => $disciplina['slug']],
                array_merge($disciplina, ['ordem' => $index + 1, 'is_active' => true])
            );
        }
    }
}
