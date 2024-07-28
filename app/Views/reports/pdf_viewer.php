<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>PDF Viewer</title>
    <style>
    body {
        margin: 0;
        padding: 0;
    }

    #viewer {
        width: 100%;
        height: 100vh;
        border: none;
    }
    </style>
</head>

<body>
    <iframe id="viewer"
        src="<?php echo base_url('assets/pdfjs/web/viewer.html?file=' . urlencode(base_url('uploads/' . $template . '.pdf'))); ?>"></iframe>
</body>

</html>