<?php

/**
 * Creates storage/app/lead-email/ksb-guide.pdf (minimal valid PDF).
 * Replace this file with your real brochure when ready.
 */

$target = dirname(__DIR__).'/storage/app/lead-email/ksb-guide.pdf';
$dir = dirname($target);
if (! is_dir($dir)) {
    mkdir($dir, 0755, true);
}

// Minimal valid PDF (opens in Acrobat/Edge; text says replace with brochure).
$b64 = 'JVBERi0xLjQKJeLjz9MKMSAwIG9iago8PC9UeXBlL0NhdGFsb2cvUGFnZXMgMiAwIFI+PgplbmRvYmoKMiAwIG9iago8PC9UeXBlL1BhZ2VzL0tpZHNbMyAwIFJdL0NvdW50IDE+PgplbmRvYmoKMyAwIG9iago8PC9UeXBlL1BhZ2UvUGFyZW50IDIgMCBSL01lZGlhQm94WzAgMCA1OTUgODQyXSAvUmVzb3VyY2VzPDwvRm9udDw8L0YxIDQgMCBSPj4+Pi9Db250ZW50cyA1IDAgUj4+CmVuZG9iago0IDAgb2JqCjw8L1R5cGUvRm9udC9TdWJ0eXBlL1R5cGUxL0Jhc2VGb250L0hlbHZldGljYT4+CmVuZG9iago1IDAgb2JqCjw8L0xlbmd0aCA0ND4+CnN0cmVhbQpCVAovRjEgMjQgVGYKMjAgNzAwIFRkCihLU0IgSG9tZXMgLSByZXBsYWNlIHdpdGggeW91ciBicm9jaHVyZSkgVGoKRVQKZW5kc3RyZWFtCmVuZG9iagp4cmVmCjAgNgowMDAwMDAwMDAwIDY1NTM1IGYgCjAwMDAwMDAwMTIgMDAwMDAgbiAKMDAwMDAwMDExNiAwMDAwMCBuIAowMDAwMDAwMTk5IDAwMDAwIG4gCjAwMDAwMDAzMjkgMDAwMDAgbiAKMDAwMDAwMDM5MiAwMDAwMCBuIAp0cmFpbGVyCjw8L1NpemUgNi9Sb290IDEgMCBSPj4Kc3RhcnR4cmVmCjQ0NAolJUVPRg==';

$data = base64_decode($b64, true);
if ($data === false) {
    fwrite(STDERR, "decode failed\n");
    exit(1);
}

file_put_contents($target, $data);
echo "Wrote {$target} (".strlen($data)." bytes)\n";
