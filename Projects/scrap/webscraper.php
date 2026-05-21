<?php
class WebScraper {
    private $url;
    private $elements = [];
    public $error = "";
    public $show_table = false;

    public function __construct($url) {
        $this->url = filter_var($url, FILTER_VALIDATE_URL);
    }

    public function scrape() {
        if (!$this->url) {
            $this->error = "❌ Invalid URL.";
            return;
        }

        $html = @file_get_contents($this->url);
        if (!$html) {
            $this->error = "❌ Unable to fetch content.";
            return;
        }

        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        @$dom->loadHTML($html);

        $tags = ['h1','h2','h3','h4','h5','h6','p','a','img','li','strong','em','title'];
        foreach ($tags as $tag) {
            foreach ($dom->getElementsByTagName($tag) as $node) {
                $type = match ($tag) {
                    'a' => 'Link',
                    'img' => 'Image',
                    'p' => 'Paragraph',
                    'li' => 'List Item',
                    'strong' => 'Bold Text',
                    'em' => 'Italic Text',
                    'title' => 'Page Title',
                    default => 'Header'
                };

                $this->elements[] = [
                    'type' => $type,
                    'tag' => $tag,
                    'content' => trim($node->textContent),
                    'href' => $tag === 'a' ? $node->getAttribute('href') : '',
                    'src' => $tag === 'img' ? $node->getAttribute('src') : ''
                ];
            }
        }
    }

    public function export($format) {
        if (empty($this->elements)) return;

        switch ($format) {
            case 'csv':
                header('Content-Type: text/csv; charset=utf-8');
                header('Content-Disposition: attachment; filename="scraped.csv"');
                $output = fopen('php://output', 'w');
                fputcsv($output, ['Type', 'Tag', 'Content', 'Link/Image']);
                foreach ($this->elements as $el) {
                    fputcsv($output, [$el['type'], $el['tag'], $el['content'], $el['href'] ?: $el['src'] ?? '']);
                }
                fclose($output);
                exit;

            case 'word':
                $content = "<table border='1'><tr><th>Type</th><th>Tag</th><th>Content</th><th>Link/Image</th></tr>";
                foreach ($this->elements as $el) {
                    $link = $el['href'] ?: $el['src'] ?? '';
                    $content .= "<tr><td>{$el['type']}</td><td>{$el['tag']}</td><td>{$el['content']}</td><td>{$link}</td></tr>";
                }
                $content .= "</table>";
                $this->html_to_doc($content);
                break;

            case 'html':
            default:
                $this->show_table = true;
        }
    }

    public function html_to_doc($content, $filename = "scraped.doc") {
        header("Content-type: application/msword");
        header("Content-Disposition: attachment;Filename={$filename}");
        echo "<html><head><meta charset='UTF-8'></head><body>";
        echo $content;
        echo "</body></html>";
        exit;
    }

    public function getElements() {
        return $this->elements;
    }

    public function shouldShowTable() {
        return $this->show_table;
    }
}

// Process form and create scraper instance only if POST request
$scraper = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $url = $_POST['url'] ?? '';
    $format = $_POST['format'] ?? 'csv';

    $scraper = new WebScraper($url);
    $scraper->scrape();
    $scraper->export($format);
}
?>
