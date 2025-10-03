<?php
// Pexeso Memory Game (9x9) with Side Hints — PHP implementation
header('Content-Type: text/html; charset=utf-8');

$pair_map = [
    'Screwdriver' => 'Screw',
    'Wrench' => 'Bolt',
    'Hammer' => 'Nail',
    'Drill' => 'Drill Bit',
    'Saw' => 'Wood Plank',
    'Chisel' => 'Wood Block',
    'Pliers' => 'Wire',
    'Level' => 'Spirit Vial',
    'Utility Knife' => 'Spare Blade',
    'Bucket' => 'Liquid',
    'Floor scoop' => 'Broom',
    'Allen Key' => 'Hex Screw',
    'Soldering Iron' => 'Solder',
    'Heat Gun' => 'Heat Shrink Tubing',
    'Staple Gun' => 'Staples',
    'Paint Roller' => 'Paint Tray',
    'Paintbrush' => 'Paint Can',
    'Sandpaper' => 'Sanding Strip',
    'Wire Stripper' => 'Cable',
    'Pipe Wrench' => 'Pipe',
    'Caulking Gun' => 'Sealant Cartridge',
    'Rivet Gun' => 'Rivet',
    'Jigsaw' => 'Curved Cut',
    'Miter Saw' => 'Trim Piece',
    'Chainsaw' => 'Log',
    'Angle Grinder' => 'Grinding Disc',
    'Orbital Sander' => 'Sanding Pad',
    'Impact Driver' => 'Impact Bit',
    'Circular Saw' => 'Circular Blade',
    'Planer' => 'Wood Board',
    'Multimeter' => 'Circuit',
    'Stud Finder' => 'Wall Stud',
    'Bolt Cutter' => 'Chain',
    'Crowbar' => 'Crate',
    'Torque Wrench' => 'Torque Adapter',
    'Stapler' => 'Staples Pack',
    'Hand Drill' => 'Drill Bit (Manual)',
    'Work Light' => 'Bulb',
    'Extension Cord' => 'Power Plug',
    'Pickaxe' => 'Rock',
    'Shovel' => 'Soil',
    'Wheelbarrow' => 'Load',
    'Anvil' => 'Hammered Metal',
    'File' => 'Metal Edge',
    'Vice' => 'Workbench',
    'Safety Goggles' => 'Eye Protection'
];

$required_pairs = 40;
if (count($pair_map) > $required_pairs) {
    // Select 40 random pairs from $pair_map
    $keys = array_keys($pair_map);
    shuffle($keys);
    $selected_keys = array_slice($keys, 0, $required_pairs);
    $pair_map = array_intersect_key($pair_map, array_flip($selected_keys));
}

$cards = [];
$pair_index = 0;
foreach ($pair_map as $tool => $accessory) {
    $pair_key = 'pair_' . $pair_index;
    $cards[] = ['id'=>uniqid('c'),'label'=>$tool,'role'=>'tool','pair_key'=>$pair_key];
    $cards[] = ['id'=>uniqid('c'),'label'=>$accessory,'role'=>'accessory','pair_key'=>$pair_key];
    $pair_index++;
}

shuffle($cards);

$board = [];
$playable_index = 0;
for ($i=0;$i<81;$i++){
    if($i===40){
        $board[]=[
            'type'=>'center',
            'id'=>'center',
            'label'=>'<div class="center-inner"><div class="center-flip"><div class="center-front"><img src="fnva_logo.png" alt="FnvA logo" style="max-width:80px;max-height:80px;border-radius:5px;"></div><div class="center-back"><a href="https://github.com/fnva" target="_blank">GitHub</a></div></div></div>',
            'disabled'=>true
        ];
    } else {
        $board[] = array_merge($cards[$playable_index],['type'=>'card']);
        $playable_index++;
    }
}

$board_json = json_encode($board, JSON_UNESCAPED_UNICODE);
$pair_map_json = json_encode($pair_map, JSON_UNESCAPED_UNICODE);
?>
<?php
// Add language support
$langs = [
  'en' => 'English',
  'sk' => 'Slovensky',
  'ru' => 'Русский',
  'hu' => 'Magyar'
];
$lang = $_GET['lang'] ?? 'en';

$translations = [
  'en' => [
    'title' => 'Memory Game — Tools/Accessories',
    'pairs_found' => 'Pairs found',
    'moves' => 'Moves',
    'time' => 'Time',
    'restart' => 'Restart',
    'tip' => 'Goal:',
    'tip_text' => 'Match tool with its accessory or usage.',
    'translation_notice' => 'Translation is not 100% accurate',
    'and' => 'and'
  ],
  'sk' => [
    'title' => 'Pamäťová hra — Náradie/Príslušenstvo',
    'pairs_found' => 'Nájdené páry',
    'moves' => 'Pohyby',
    'time' => 'Čas',
    'restart' => 'Reštartovať',
    'tip' => 'Cieľ:',
    'tip_text' => 'Spojte náradie s jeho príslušenstvom a využitím.',
    'translation_notice' => 'Preklad nie je 100% presný',
    'and' => 'a'
  ],
  'ru' => [
    'title' => 'Игра на память — Инструменты/Аксессуары',
    'pairs_found' => 'Найдено пар',
    'moves' => 'Ходы',
    'time' => 'Время',
    'restart' => 'Перезапуск',
    'tip' => 'Задача:',
    'tip_text' => 'Соедините инструмент с аксессуаром или его предназначением.',
    'translation_notice' => 'Перевод не на 100% точен',
    'and' => 'и'
  ],
  'hu' => [
    'title' => 'Memóriajáték — Szerszámok/Kiegészítők',
    'pairs_found' => 'Talált párok',
    'moves' => 'Lépések',
    'time' => 'Idő',
    'restart' => 'Újraindítás',
    'tip' => 'Сél:',
    'tip_text' => 'Párosítsd a szerszámot a kiegészítőjével vagy felhasználásával.',
    'translation_notice' => 'Fordítás nem 100% pontos',
    'and' => 'és'
  ]
];
$t = $translations[$lang] ?? $translations['en'];
$item_translations = [
  'en' => [
    'Screwdriver' => 'Screwdriver',
    'Screw' => 'Screw',
    'Wrench' => 'Wrench',
    'Bolt' => 'Bolt',
    'Hammer' => 'Hammer',
    'Nail' => 'Nail',
    'Drill' => 'Drill',
    'Drill Bit' => 'Drill Bit',
    'Saw' => 'Saw',
    'Wood Plank' => 'Wood Plank',
    'Chisel' => 'Chisel',
    'Wood Block' => 'Wood Block',
    'Pliers' => 'Pliers',
    'Wire' => 'Wire',
    'Level' => 'Level',
    'Spirit Vial' => 'Spirit Vial',
    'Utility Knife' => 'Utility Knife',
    'Spare Blade' => 'Spare Blade',
    'Bucket' => 'Bucket',
    'Liquid' => 'Liquid',
    'Floor scoop' => 'Floor scoop',
    'Broom' => 'Broom',
    'Allen Key' => 'Allen Key',
    'Hex Screw' => 'Hex Screw',
    'Soldering Iron' => 'Soldering Iron',
    'Solder' => 'Solder',
    'Heat Gun' => 'Heat Gun',
    'Heat Shrink Tubing' => 'Heat Shrink Tubing',
    'Staple Gun' => 'Staple Gun',
    'Staples' => 'Staples',
    'Paint Roller' => 'Paint Roller',
    'Paint Tray' => 'Paint Tray',
    'Paintbrush' => 'Paintbrush',
    'Paint Can' => 'Paint Can',
    'Sandpaper' => 'Sandpaper',
    'Sanding Strip' => 'Sanding Strip',
    'Wire Stripper' => 'Wire Stripper',
    'Cable' => 'Cable',
    'Pipe Wrench' => 'Pipe Wrench',
    'Pipe' => 'Pipe',
    'Caulking Gun' => 'Caulking Gun',
    'Sealant Cartridge' => 'Sealant Cartridge',
    'Rivet Gun' => 'Rivet Gun',
    'Rivet' => 'Rivet',
    'Jigsaw' => 'Jigsaw',
    'Curved Cut' => 'Curved Cut',
    'Miter Saw' => 'Miter Saw',
    'Trim Piece' => 'Trim Piece',
    'Chainsaw' => 'Chainsaw',
    'Log' => 'Log',
    'Angle Grinder' => 'Angle Grinder',
    'Grinding Disc' => 'Grinding Disc',
    'Orbital Sander' => 'Orbital Sander',
    'Sanding Pad' => 'Sanding Pad',
    'Impact Driver' => 'Impact Driver',
    'Impact Bit' => 'Impact Bit',
    'Circular Saw' => 'Circular Saw',
    'Circular Blade' => 'Circular Blade',
    'Planer' => 'Planer',
    'Wood Board' => 'Wood Board',
    'Multimeter' => 'Multimeter',
    'Circuit' => 'Circuit',
    'Stud Finder' => 'Stud Finder',
    'Wall Stud' => 'Wall Stud',
    'Bolt Cutter' => 'Bolt Cutter',
    'Chain' => 'Chain',
    'Crowbar' => 'Crowbar',
    'Crate' => 'Crate',
    'Torque Wrench' => 'Torque Wrench',
    'Torque Adapter' => 'Torque Adapter',
    'Stapler' => 'Stapler',
    'Staples Pack' => 'Staples Pack',
    'Hand Drill' => 'Hand Drill',
    'Drill Bit (Manual)' => 'Drill Bit (Manual)',
    'Work Light' => 'Work Light',
    'Bulb' => 'Bulb',
    'Extension Cord' => 'Extension Cord',
    'Power Plug' => 'Power Plug',
    'Pickaxe' => 'Pickaxe',
    'Rock' => 'Rock',
    'Shovel' => 'Shovel',
    'Soil' => 'Soil',
    'Wheelbarrow' => 'Wheelbarrow',
    'Load' => 'Load',
    'Anvil' => 'Anvil',
    'Hammered Metal' => 'Hammered Metal',
    'File' => 'File',
    'Metal Edge' => 'Metal Edge',
    'Vice' => 'Vice',
    'Workbench' => 'Workbench',
    'Safety Goggles' => 'Safety Goggles',
    'Eye Protection' => 'Eye Protection'
  ],
  'sk' => [
    'Screwdriver' => 'Skrutkovač',
    'Screw' => 'Skrutka',
    'Wrench' => 'Kľúč',
    'Bolt' => 'Šrób',
    'Hammer' => 'Kladivo',
    'Nail' => 'Klinec',
    'Drill' => 'Vŕtačka',
    'Drill Bit' => 'Vrták',
    'Saw' => 'Píla',
    'Wood Plank' => 'Doska',
    'Chisel' => 'Zúbkovaný nôž',
    'Wood Block' => 'Blok',
    'Pliers' => 'Kliešte',
    'Wire' => 'Drôt',
    'Level' => 'Vodováha',
    'Spirit Vial' => 'Liehová fľaša',
    'Utility Knife' => 'Kapský nôž',
    'Spare Blade' => 'Náhradná čepeľ',
    'Bucket' => 'Vedro',
    'Liquid' => 'Tekutina',
    'Floor scoop' => 'Lopatka',
    'Broom' => 'Metla',
    'Allen Key' => 'Imbusový kľúč',
    'Hex Screw' => 'Šesťhranný skrutka',
    'Soldering Iron' => 'Cínovačka',
    'Solder' => 'Cín',
    'Heat Gun' => 'Teplovzdušná pištoľ',
    'Heat Shrink Tubing' => 'Skrátená hadica',
    'Staple Gun' => 'Sponkovačka',
    'Staples' => 'Sponky',
    'Paint Roller' => 'Valček na maľovanie',
    'Paint Tray' => 'Paleta na farbu',
    'Paintbrush' => 'Štetec',
    'Paint Can' => 'Plecha na farbu',
    'Sandpaper' => 'Brúsny papier',
    'Sanding Strip' => 'Brúsny pás',
    'Wire Stripper' => 'Odizolovač',
    'Cable' => 'Kábel',
    'Pipe Wrench' => 'Rúrový kľúč',
    'Pipe' => 'Rúra',
    'Caulking Gun' => 'Silikónová pištoľ',
    'Sealant Cartridge' => 'Kazeta so silikónom',
    'Rivet Gun' => 'Rivetová pištoľ',
    'Rivet' => 'Rivet',
    'Jigsaw' => 'Píla na železo',
    'Curved Cut' => 'Zakřivený rez',
    'Miter Saw' => 'Píla na uhlový rez',
    'Trim Piece' => 'Obložkový rez',
    'Chainsaw' => 'Motorová píla',
    'Log' => 'Kmeň',
    'Angle Grinder' => 'Uhlová brúska',
    'Grinding Disc' => 'Brúsny kotúč',
    'Orbital Sander' => 'Orbitálna brúska',
    'Sanding Pad' => 'Brúsny kotúč',
    'Impact Driver' => 'Rázový uťahovač',
    'Impact Bit' => 'Rázový bit',
    'Circular Saw' => 'Okružná píla',
    'Circular Blade' => 'Okružný kotúč',
    'Planer' => 'Hoblík',
    'Wood Board' => 'Drevotriesková doska',
    'Multimeter' => 'Multimeter',
    'Circuit' => 'Obvod',
    'Stud Finder' => 'Hľadáč trámov',
    'Wall Stud' => 'Trám',
    'Bolt Cutter' => 'Kliešte na šróby',
    'Chain' => 'Reťaz',
    'Crowbar' => 'Páčidlo',
    'Crate' => 'Debna',
    'Torque Wrench' => 'Momentový kľúč',
    'Torque Adapter' => 'Adaptér na momentový kľúč',
    'Stapler' => 'Zatváračka',
    'Staples Pack' => 'Balenie sponiek',
    'Hand Drill' => 'Ručná vŕtačka',
    'Drill Bit (Manual)' => 'Vrták (ručne ovládaný)',
    'Work Light' => 'Pracovná lampa',
    'Bulb' => 'Žiarovka',
    'Extension Cord' => 'Predlžovací kábel',
    'Power Plug' => 'Napájací konektor',
    'Pickaxe' => 'Kladivo na kamene',
    'Rock' => 'Kameň',
    'Shovel' => 'Lopata',
    'Soil' => 'Pôda',
    'Wheelbarrow' => 'Záhradný vozík',
    'Load' => 'Náklad',
    'Anvil' => 'Kováčske kladivo',
    'Hammered Metal' => 'Kováčska oceľ',
    'File' => 'Súbor',
    'Metal Edge' => 'Kovový okraj',
    'Vice' => 'Sviečka',
    'Workbench' => 'Pracovný stôl',
    'Safety Goggles' => 'Ochranné okuliare',
    'Eye Protection' => 'Ochrana očí'
  ],
  'ru' => [
    'Screwdriver' => 'Отвёртка',
    'Screw' => 'Винт',
    'Wrench' => 'Гаечный ключ',
    'Bolt' => 'Болт',
    'Hammer' => 'Молоток',
    'Nail' => 'Гвоздь',
    'Drill' => 'Дрель',
    'Drill Bit' => 'Сверло',
    'Saw' => 'Пила',
    'Wood Plank' => 'Деревянная доска',
    'Chisel' => 'Долото',
    'Wood Block' => 'Деревянный блок',
    'Pliers' => 'Плоскогубцы',
    'Wire' => 'Проволока',
    'Level' => 'Уровень',
    'Spirit Vial' => 'Ампула с жидкостью',
    'Utility Knife' => 'Нож универсальный',
    'Spare Blade' => 'Запасное лезвие',
    'Bucket' => 'Ведро',
    'Liquid' => 'Жидкость',
    'Floor scoop' => 'Совок',
    'Broom' => 'Метла',
    'Allen Key' => 'Шестигранный ключ',
    'Hex Screw' => 'Шестигранный винт',
    'Soldering Iron' => 'Паяльник',
    'Solder' => 'Припой',
    'Heat Gun' => 'Термофен',
    'Heat Shrink Tubing' => 'Термоусадочная трубка',
    'Staple Gun' => 'Строительный степлер',
    'Staples' => 'Скобы',
    'Paint Roller' => 'Валик для краски',
    'Paint Tray' => 'Поддон для краски',
    'Paintbrush' => 'Кисть',
    'Paint Can' => 'Банка с краской',
    'Sandpaper' => 'Шлифовальная бумага',
    'Sanding Strip' => 'Шлифовальная полоска',
    'Wire Stripper' => 'Стриппер',
    'Cable' => 'Кабель',
    'Pipe Wrench' => 'Трубный ключ',
    'Pipe' => 'Труба',
    'Caulking Gun' => 'Пистолет для герметика',
    'Sealant Cartridge' => 'Картридж с герметиком',
    'Rivet Gun' => 'Заклёпочник',
    'Rivet' => 'Заклёпка',
    'Jigsaw' => 'Лобзик',
    'Curved Cut' => 'Изогнутый рез',
    'Miter Saw' => 'Торцовочная пила',
    'Trim Piece' => 'Отделочный элемент',
    'Chainsaw' => 'Бензопила',
    'Log' => 'Бревно',
    'Angle Grinder' => 'Угловая шлифмашина',
    'Grinding Disc' => 'Шлифовальный диск',
    'Orbital Sander' => 'Орбитальная шлифмашина',
    'Sanding Pad' => 'Шлифовальная насадка',
    'Impact Driver' => 'Ударный шуруповёрт',
    'Impact Bit' => 'Бита ударная',
    'Circular Saw' => 'Циркулярная пила',
    'Circular Blade' => 'Диск для пилы',
    'Planer' => 'Рубанок',
    'Wood Board' => 'Деревянная плита',
    'Multimeter' => 'Мультиметр',
    'Circuit' => 'Цепь',
    'Stud Finder' => 'Детектор стоек',
    'Wall Stud' => 'Стойка',
    'Bolt Cutter' => 'Болторез',
    'Chain' => 'Цепь',
    'Crowbar' => 'Лом',
    'Crate' => 'Ящик',
    'Torque Wrench' => 'Динамометрический ключ',
    'Torque Adapter' => 'Адаптер для ключа',
    'Stapler' => 'Степлер',
    'Staples Pack' => 'Пачка скоб',
    'Hand Drill' => 'Ручная дрель',
    'Drill Bit (Manual)' => 'Сверло (ручное)',
    'Work Light' => 'Рабочая лампа',
    'Bulb' => 'Лампочка',
    'Extension Cord' => 'Удлинитель',
    'Power Plug' => 'Вилка',
    'Pickaxe' => 'Кирка',
    'Rock' => 'Камень',
    'Shovel' => 'Лопата',
    'Soil' => 'Почва',
    'Wheelbarrow' => 'Тележка',
    'Load' => 'Груз',
    'Anvil' => 'Наковальня',
    'Hammered Metal' => 'Кованый металл',
    'File' => 'Напильник',
    'Metal Edge' => 'Металлический край',
    'Vice' => 'Тиски',
    'Workbench' => 'Верстак',
    'Safety Goggles' => 'Защитные очки',
    'Eye Protection' => 'Защита глаз'
  ],
  'hu' => [
    'Screwdriver' => 'Csavarhúzó',
    'Screw' => 'Csavar menetes',
    'Wrench' => 'Csavarkulcs',
    'Bolt' => 'Csavar',
    'Hammer' => 'Kalapács',
    'Nail' => 'Szög',
    'Drill' => 'Fúró',
    'Drill Bit' => 'Fúrófej',
    'Saw' => 'Fűrész',
    'Wood Plank' => 'Fadarab',
    'Chisel' => 'Véső',
    'Wood Block' => 'Fa blokk',
    'Pliers' => 'Fogó',
    'Wire' => 'Vezeték',
    'Level' => 'Vízszintező',
    'Spirit Vial' => 'Libella',
    'Utility Knife' => 'Szakácskés / Univerzális kés',
    'Spare Blade' => 'Cserepenge',
    'Bucket' => 'Vödör',
    'Liquid' => 'Folyadék',
    'Floor scoop' => 'Lapát',
    'Broom' => 'Seprű',
    'Allen Key' => 'Imbuszkulcs',
    'Hex Screw' => 'Hatszögletű csavar',
    'Soldering Iron' => 'Forrasztópáka',
    'Solder' => 'Forraszanyag',
    'Heat Gun' => 'Hőlégfúvó',
    'Heat Shrink Tubing' => 'Hőre zsugorodó cső',
    'Staple Gun' => 'Szögezőpisztoly',
    'Staples' => 'Kapcsok',
    'Paint Roller' => 'Festőhenger',
    'Paint Tray' => 'Festéktálca',
    'Paintbrush' => 'Ecset',
    'Paint Can' => 'Festékes doboz',
    'Sandpaper' => 'Csiszolópapír',
    'Sanding Strip' => 'Csiszoló szalag',
    'Wire Stripper' => 'Kábelcsupaszító',
    'Cable' => 'Kábel',
    'Pipe Wrench' => 'Csőkulcs',
    'Pipe' => 'Cső',
    'Caulking Gun' => 'Tömítőpisztoly',
    'Sealant Cartridge' => 'Tömítő patron',
    'Rivet Gun' => 'Szegecselő pisztoly',
    'Rivet' => 'Szegecs',
    'Jigsaw' => 'Dekopírfűrész',
    'Curved Cut' => 'Ívelt vágás',
    'Miter Saw' => 'Gérvágó fűrész',
    'Trim Piece' => 'Díszvágás',
    'Chainsaw' => 'Láncfűrész',
    'Log' => 'Fatönk',
    'Angle Grinder' => 'Sarokcsiszoló',
    'Grinding Disc' => 'Csiszolókorong',
    'Orbital Sander' => 'Orbitális csiszoló',
    'Sanding Pad' => 'Csiszoló párna',
    'Impact Driver' => 'Ütve csavarozó',
    'Impact Bit' => 'Ütve bit',
    'Circular Saw' => 'Körfűrész',
    'Circular Blade' => 'Körkörös lap',
    'Planer' => 'Gyalu',
    'Wood Board' => 'Fa tábla',
    'Multimeter' => 'Multiméter',
    'Circuit' => 'Áramkör',
    'Stud Finder' => 'Faljelző',
    'Wall Stud' => 'Falgerenda',
    'Bolt Cutter' => 'Csővágó/ Rétvágó',
    'Chain' => 'Lánc',
    'Crowbar' => 'Emelővas',
    'Crate' => 'Láda',
    'Torque Wrench' => 'Nyomatékkulcs',
    'Torque Adapter' => 'Nyomaték adapter',
    'Stapler' => 'Papír tűzőgép',
    'Staples Pack' => 'Kapocs csomag',
    'Hand Drill' => 'Kézi fúró',
    'Drill Bit (Manual)' => 'Fúrófej (kézi)',
    'Work Light' => 'Munkalámpa',
    'Bulb' => 'Izzó',
    'Extension Cord' => 'Hosszabbító kábel',
    'Power Plug' => 'Dugó',
    'Pickaxe' => 'Csákány',
    'Rock' => 'Kő',
    'Shovel' => 'Lapát',
    'Soil' => 'Talaj',
    'Wheelbarrow' => 'Talicska',
    'Load' => 'Teher',
    'Anvil' => 'Kovács üllő',
    'Hammered Metal' => 'Kalapált fém',
    'File' => 'Reszelő',
    'Metal Edge' => 'Fém él',
    'Vice' => 'Satu',
    'Workbench' => 'Munkapad',
    'Safety Goggles' => 'Védőszemüveg',
    'Eye Protection' => 'Szemvédelem'
  ]
];
$t = $translations[$lang] ?? $translations['en'];
$item_t = $item_translations[$lang] ?? $item_translations['en'];
?>
<!doctype html>
<html lang="<?php echo $lang; ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?php echo $t['title']; ?></title>
<style>
:root{--tile-size:80px}
body{font-family:Inter,system-ui,Segoe UI,Roboto,Arial;margin:16px;background:#EEEEEE;color:#e6eef8}
.container{max-width:1280px;margin:0 auto;display:flex;gap:16px}
.header{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px}
.title{font-size:26px;font-weight:600}
.controls{display:flex;gap:8px;align-items:center}
button{background:#2563eb;color:white;border:none;padding:8px 12px;border-radius:8px;cursor:pointer}
button.ghost{background:transparent;border:1px solid rgba(255,255,255,0.08)}
.board{display:grid;grid-template-columns:repeat(9,var(--tile-size));grid-template-rows:repeat(9,var(--tile-size));gap:8px;justify-content:center}
.tile{width:var(--tile-size);height:var(--tile-size);perspective:800px;}
.tile-inner{position:relative;width:100%;height:100%;transform-style:preserve-3d;transition:transform .45s}
.tile.flipped .tile-inner{transform:rotateY(180deg)}
.face{position:absolute;inset:0;border-radius:10px;display:flex;align-items:center;justify-content:center;backface-visibility:hidden;box-shadow:0 4px 8px rgba(2,6,23,.6)}
.face.front{background:linear-gradient(180deg,#555555,#222222);color:#bcd7ff}
.face.back {
  background: linear-gradient(180deg,#e6eef8,#cfe3ff);
  color: #000000;
  transform: rotateY(180deg);
  font-size: 16px;
  padding: 4px;
  text-align: center;
  white-space: normal;      /* Allow wrapping */
  word-break: break-word;   /* Break long words */
  hyphens: auto;            /* Hyphenate if possible */
  line-height: 1.1;         /* Slightly tighter lines */
  overflow-wrap: anywhere;  /* Break anywhere if needed */
}
.face.center .center-inner {
  position: relative;
  width: 100%;
  height: 100%;
  perspective: 800px;
}
.face.center .center-flip {
  width: 100%;
  height: 100%;
  transition: transform .45s;
  transform-style: preserve-3d;
  position: relative;
}
.face.center:hover .center-flip {
  transform: rotateY(180deg);
}
.face.center .center-front,
.face.center .center-back {
  position: absolute;
  inset: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  backface-visibility: hidden;
  width: 100%;
  height: 100%;
}
.face.center .center-front {
  z-index: 2;
}
.face.center .center-back {
  transform: rotateY(180deg);
  font-size: 22px;
  color: #ec0707ff;
  background: none;
  font-weight: bold;
  z-index: 3;
}
.face.center .center-front img {
  transition: opacity .11s;
}
.face.center:hover .center-front img {
  opacity: 0;
}
.matched .tile-inner{opacity:.35;transform:none}
.status{margin-top:20px;color:#9fb3d5}
.legend{font-size:24px;color:#9fb3d5}
.footer{margin-top:12px;font-size:26px;color:#9fb3d5}
.info-bubble{font-size:22px;color:#cde6ff}
.hints{width:200px;font-size:18px;line-height:1.4}
.hints ul{list-style:none;padding:0;margin:0;}
.hints li{margin-bottom:4px}
.hints li.matched{color:#64748b;text-decoration:line-through}
.hints span.highlight{color:#ff0000;font-weight:bold}

/* Replace or add these lines in the <style> section to make all text black */
body,
.title,
.controls,
.legend,
.footer,
.info-bubble,
.status,
.hints,
.hints ul,
.hints li,
.hints span,
.face.front,
.face.back,
.face.center,
.face.center .center-back {
  color: #000 !important;
}
</style>
</head>
<body>
<div class="header">
  <div class="title"><?php echo $t['title']; ?></div>
  <div class="controls">
    <div class="legend"><?php echo $t['pairs_found']; ?>: <span id="score">0</span>/40</div>
    <div class="legend"><?php echo $t['moves']; ?>: <span id="moves">0</span></div>
    <div class="legend"><?php echo $t['time']; ?>: <span id="timer">00:00</span></div>
    <button id="restart"><?php echo $t['restart']; ?></button>
    <!-- Language selector -->
    <select id="lang-select">
      <?php foreach($langs as $code=>$name): ?>
        <option value="<?php echo $code; ?>" <?php if($lang==$code)echo 'selected'; ?>><?php echo $name; ?></option>
      <?php endforeach; ?>
    </select>
  </div>
</div>
<div class="container">
  <div class="hints" id="hints-left">
    <ul></ul>
  </div>
  <div>
    <div id="board" class="board" role="grid" aria-label="Pexeso board"></div>
    <div class="status"><span class="info-bubble"><?php echo $t['tip']; ?></span> <?php echo $t['tip_text']; ?></div>
    <div class="status"><span class="info-bubble"><?php echo $t['translation_notice']; ?></span></div>
  </div>
  <div class="hints" id="hints-right">
    <ul></ul>
  </div>
</div>

<script>
const rawBoard = <?php echo $board_json; ?>;
const pairMap = <?php echo $pair_map_json; ?>;
const translations = <?php echo json_encode($translations, JSON_UNESCAPED_UNICODE); ?>;
const itemTranslations = <?php echo json_encode($item_t, JSON_UNESCAPED_UNICODE); ?>;
const lang = "<?php echo $lang; ?>";
const t = translations[lang];

let board = JSON.parse(JSON.stringify(rawBoard));
let firstPick = null;
let secondPick = null;
let lockBoard = false;
let matches = 0;
let moves = 0;
let seconds = 0;
let timerInterval = null;

const boardEl = document.getElementById('board');
const scoreEl = document.getElementById('score');
const movesEl = document.getElementById('moves');
const timerEl = document.getElementById('timer');
const restartBtn = document.getElementById('restart');
const langSelect = document.getElementById('lang-select');

langSelect.addEventListener('change', function() {
  window.location.search = '?lang=' + this.value;
});

const hintsLeft = document.querySelector('#hints-left ul');
const hintsRight = document.querySelector('#hints-right ul');
let hintItems = {};

function formatTime(s){
  const mm = String(Math.floor(s/60)).padStart(2,'0');
  const ss = String(s%60).padStart(2,'0');
  return `${mm}:${ss}`;
}

function startTimer(){ if (timerInterval) clearInterval(timerInterval); seconds=0; timerEl.textContent=formatTime(seconds); timerInterval=setInterval(()=>{seconds++;timerEl.textContent=formatTime(seconds);},1000);} 
function stopTimer(){ if(timerInterval) clearInterval(timerInterval); timerInterval=null; }

function renderBoard(){
  boardEl.innerHTML = '';
  board.forEach((cell, idx) => {
    const tile=document.createElement('div');tile.className='tile';tile.setAttribute('data-index', idx);
    const inner=document.createElement('div');inner.className='tile-inner';
    const front=document.createElement('div');front.className='face front';
    const back=document.createElement('div');back.className='face back';

    if(cell.type==='center'){
      front.className='face center';front.innerHTML=cell.label;inner.appendChild(front);tile.appendChild(inner);tile.classList.add('disabled');
    } else {
      front.textContent='';back.innerHTML = itemTranslations[cell.label] || cell.label;inner.appendChild(front);inner.appendChild(back);tile.appendChild(inner);
      tile.addEventListener('click',()=>onTileClick(idx,tile));
      if(cell.matched){tile.classList.add('matched');tile.classList.add('flipped');}
    }
    boardEl.appendChild(tile);
  });
}

function revealAllAtStart(){
  const tiles = boardEl.querySelectorAll('.tile:not(.disabled)');
  tiles.forEach(tile => tile.classList.add('flipped'));
  lockBoard = true;
  setTimeout(() => {
    tiles.forEach(tile => tile.classList.remove('flipped'));
    lockBoard = false;
  }, 3000);
}

function renderHints(){
  hintsLeft.innerHTML='';
  hintsRight.innerHTML='';
  const entries = Object.entries(pairMap);
  entries.forEach((pair,i)=>{
    const [tool,accessory]=pair;
    const li=document.createElement('li');
    const toolSpan=document.createElement('span');
    const accSpan=document.createElement('span');
    toolSpan.textContent = itemTranslations[tool] || tool;
    accSpan.textContent = itemTranslations[accessory] || accessory;
    toolSpan.dataset.role='tool';
    accSpan.dataset.role='accessory';
    toolSpan.dataset.pair='pair_'+i;
    accSpan.dataset.pair='pair_'+i;
    li.appendChild(toolSpan);
    li.insertAdjacentText('beforeend',' ↔ ');
    li.appendChild(accSpan);
    hintItems['pair_'+i] = {li, toolSpan, accSpan};
    if(i<20) hintsLeft.appendChild(li); else hintsRight.appendChild(li);
  });
}

function highlightHint(cell, highlight){
  const item = hintItems[cell.pair_key];
  if(!item) return;
  if(cell.role==='tool'){
    item.toolSpan.classList.toggle('highlight',highlight);
  } else {
    item.accSpan.classList.toggle('highlight',highlight);
  }
}

function clearAllHighlights(){
  Object.values(hintItems).forEach(item=>{
    item.toolSpan.classList.remove('highlight');
    item.accSpan.classList.remove('highlight');
  });
}

function onTileClick(index,tileEl){
  if(lockBoard) return;
  const cell=board[index];
  if(cell.type!=='card'||cell.matched) return;
  if(tileEl.classList.contains('flipped')) return;
  if(!timerInterval&&moves===0&&matches===0) startTimer();
  tileEl.classList.add('flipped');

  highlightHint(cell,true);

  if(!firstPick){firstPick={index,cell,el:tileEl};return;}
  if(firstPick.index===index) return;

  secondPick={index,cell,el:tileEl};moves++;movesEl.textContent=moves;

  if(firstPick.cell.pair_key===secondPick.cell.pair_key){
    board[firstPick.index].matched=true;
    board[secondPick.index].matched=true;
    firstPick.el.classList.add('matched');
    secondPick.el.classList.add('matched');
    matches++;scoreEl.textContent=matches;

    const item = hintItems[firstPick.cell.pair_key];
    if(item){
      item.toolSpan.classList.remove('highlight');
      item.accSpan.classList.remove('highlight');
      item.li.classList.add('matched');
    }

    firstPick=null;secondPick=null;
    if(matches>=40){
      stopTimer();
      setTimeout(()=>alert(`${t['moves']} ${formatTime(seconds)}!`),300);
    }
  } else {
    lockBoard=true;
    setTimeout(()=>{
      firstPick.el.classList.remove('flipped');
      secondPick.el.classList.remove('flipped');
      clearAllHighlights();
      firstPick=null;secondPick=null;
      lockBoard=false;
    },900);
  }
}

function restartGame(){location.reload();}

restartBtn.addEventListener('click',restartGame);

renderBoard();
renderHints();
revealAllAtStart();
</script>
</body>
</html>
