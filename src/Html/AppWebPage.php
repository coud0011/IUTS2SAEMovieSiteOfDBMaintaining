<?php

# File created by Axel Coudrot
# Created with PhpStorm by JetBrains Studios
# License for JetBrains : student Noncommercial

declare(strict_types=1);

namespace Html;

class AppWebPage extends WebPage
{
    public function __construct(String $title="")
    {
        parent::__construct($title);
        $this->appendCssUrl("/css/style.css");
    }

    public function toHTML(): string
    {
        $date=WebPage::getLastModification();
        return <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1" />{$this->getHead()}
                <title>{$this->getTitle()}</title>
            </head>
            <body>
                <header class="header"><h1>{$this->getTitle()}</h1></header>
                <main class="content">{$this->getBody()}</main>
                <footer class="footer">
                    Dernière modification : $date
                </footer>
            </body>
        </html>
        HTML;
    }
}
