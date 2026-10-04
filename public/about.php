<?php 
    session_start();
    require_once __DIR__."\\..\\includes\\htmlFunctions.php";
    // Getting page data
    $data = json_decode(file_get_contents(__DIR__."\\..\\json\\about_company.json"), true);
    // Preparing output data
    $page_title = 'О компании';
    $page_css_list = ['about'];
    ob_start();
    include __DIR__.'\\..\\templates\\about.html.php';
    $page_content = ob_get_clean();
    // Displaying page to user
    include __DIR__.'\\..\\templates\\layout.html.php';
?>