<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo $this->config->basePath ?>/assets/" >
		<link rel="stylesheet" href="css/styles.css" />
	</head>
	<body class="fade">
		<header class="span12">{ File Viewer }</header>
			<?php include $this->path ?>
		<footer class="span12">
			{ File Viewer }
			<iframe src="http://ghbtns.com/github-btn.html?user=web-mech&repo=FileViewer&type=watch&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="62" height="20"></iframe>
		</footer>
		<script src="js/lib/require/require.js" data-main="js/app"></script>
	</body>
</html>