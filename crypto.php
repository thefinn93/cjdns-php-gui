<html>
<head>
<title>EZcrypt test</title>
<!-- copied from ezcrypt... -->
<script type="text/javascript">
	var lib = 'CRYPTO_JS';
	
	// holder object to store jquery commands until jquery is loaded up
	window.$ = ( function() {
		var q = [], f = function( cb ) {
			q.push( cb );
		};
		f.attachReady = function( $ ) { 
			$( function () {
				$.each( q, function( i, f ) {
					f.call( document );
				} );
				q.length = 0;
			} );
			return $;
		}
		return f;
	} )();
</script>
<script type="text/javascript" src="crypto/LAB.min.js"></script>
<script type="text/javascript" src="crypto/core.js"></script>
</head>
<body>

<textarea id="wangs">encrypt me!</textarea><br />
<button onclick="doit()">do it</button><br />
Out: <pre id="out"></pre>
pw: <code id="pass"></code>

<!-- copied from ezcrypt -->
	<script type="text/javascript" charset="utf8" src="crypto/jquery-1.7.1.min.js"></script>
<script type="text/javascript" charset="utf8">
	$.noConflict();
	jQuery( document ).ready( function() {
		$ = $.attachReady( jQuery.noConflict() );
	} );
</script>
<script type="text/javascript" src="crypto/codemirror/codemirror.min.js"></script>
<script type="text/javascript" src="crypto/codemirror/mode/combined.min.js"></script>
<script type="text/javascript" src="crypto/crypt.js"></script>

<!-- mine -->
<script type="text/javascript">
ezcrypt();
function doit() {
	ez = this;
	pw = generateKey();
	document.getElementById("out").innerHTML = encrypt(pw, document.getElementById("wangs"));
	document.getElementById("pass").innerHTML = pw;
}
</script>
</body>
</html>
