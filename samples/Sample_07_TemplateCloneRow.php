<?php
include_once 'Sample_Header.php';

// Template processor instance creation
echo date('H:i:s'), ' Creating new TemplateProcessor instance...', EOL;
$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('resources/114255Certificat BLS-AED - version electronique_2018-08-28.odt');

// Variables on different parts of document
$templateProcessor->setValue(['title', 'firstname', 'lastname'], ['Mr.','John','Doe']);            // On section/content
echo date('H:i:s'), ' Saving the result document...', EOL;
$templateProcessor->saveAs('results/114255Certificat BLS-AED - version electronique_2018-08-28.odt');

echo getEndingNotes(array('ODText' => 'odt'), 'results/114255Certificat BLS-AED - version electronique_2018-08-28.odt');
if (!CLI) {
    include_once 'Sample_Footer.php';
}
