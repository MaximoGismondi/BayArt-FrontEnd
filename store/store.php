<html>

<head>
	<link rel="shortcut icon" href="../icons/icon-viewer.png" />
	<link rel="stylesheet" href="styles-store.css">
	<link rel="stylesheet" href="../styles-general.css">
	<meta http-equiv="Content-Type" content=”text/html; charset=UTF-8″ />
	<meta name="viewport" content="width=device-width, user-scalable=no">
	<title>BayArt! - Store</title>
</head>

<?php

include "../php-functions.php";

session_start();

$API_URL = "http://localhost:8888/api/bpoints/" . $_SESSION["idUser"];
$res = getUrl($API_URL);
$status = $res[0];
$infoResponse = $res[1];
$resultado = json_decode($infoResponse, true);

$_SESSION["bpoints"] = $resultado["bpoints"];

$reset = "true";

if (!empty($_GET["tags"])) {
	$tags = $_GET["tags"];
} else {
	$tags = "null";
}

if (!empty($_GET["maxPrice"])) {
	$maxPrice = $_GET["maxPrice"];
} else {
	$maxPrice = "10000";
}

if (!empty($_GET["index"])) {
	$index = $_GET["index"];

	if ($index < 1) {
		$index = 1;
	}
	if ($index > $_SESSION["maxIndex"]) {
		$index = $_SESSION["maxIndex"];
	}
	$reset = "false";
} else {
	$index = 1;
}

if (empty($_GET["index"]) && !empty($_GET["tags"])) {
	$openFilters = true;
} else {
	$openFilters = false;
}

$API_URL = "http://localhost:8888/api/store/" . $_SESSION["idUser"] . "/" . $index . "/" . $reset;
$requestBody = json_encode(array("tags" => $tags, "maxPrice" => $maxPrice));
$res = postUrlRequestBody($API_URL, $requestBody);
$status = $res[0];
$infoResponse = $res[1];
$resultado = json_decode($infoResponse, true);

$infoImages = array();
$infoBookmarks = array();

if ($status == 200) { // ok

	if (empty($_GET["index"])) {
		$_SESSION["maxIndex"] = $resultado["maxIndex"];
	}

	$encodedImages        = $resultado["imagesEncoded"];
	$encodedProfiles      = $resultado["profileImages"];
	$images               = $resultado["images"];
	$artists              = $resultado["artists"];

	foreach ($images as $image) {
		$idImage         = $image["idImage"];
		$idArtist        = $image["idUser"];
		$encodedProfile  = $encodedProfiles[$idArtist];
		$encodedImage    = $encodedImages[$idImage];
		$title    		 = $image["name"];
		$username 	 	 = getUsername($image["idUser"], $artists);
		$srcImage        = '../images/images/' . $title . getExtension($encodedImage[0]);
		$srcImageProfile = '../images/artistsProfileImages/' . $username . getExtension($encodedProfile[0]);

		saveImage('../images/images/', $title, $encodedImage);
		saveImage('../images/artistsProfileImages/', $username, $encodedProfile);

		$infoImage = array();

		array_push($infoImage, $username);
		array_push($infoImage, $srcImageProfile);
		array_push($infoImage, $title);
		array_push($infoImage, $srcImage);

		array_push($infoImages, $infoImage);
	}

	if ($index == 1) {
		$bookmarksImages = $resultado["bookmarksImages"];
		$encodedBookmarks = $resultado["encodedBookmarksImages"];

		foreach ($bookmarksImages as $bookmarkImage) {
			$idImage         = $bookmarkImage["idImage"];
			$title    		 = $bookmarkImage["name"];
			$encodedBookmark = $encodedBookmarks[$idImage];
			$srcImage        = '../images/images/' . $title . getExtension($encodedBookmark[0]);

			$infoBookmark = array();
			saveImage('../images/images/', $title, $encodedBookmark);

			array_push($infoBookmark, $srcImage);
			array_push($infoBookmark, $title);
			array_push($infoBookmark, $idImage);

			array_push($infoBookmarks, $infoBookmark);
		}
	}
}
?>

<body class="scrollbar">

	<div id="purple-line" class="line"></div>
	<div id="green-line" class="line"></div>

	<header>

		<!--Header Principal-->

		<div id="div-buttons">

			<button id="button-homePage" class="options" onclick="location.href='../homepage/homepage.php'">
				<img src="../icons/house.png" class="img-buttons">
			</button>

			<button id="button-browse" class="options" onclick="location.href='../browse/browse.php'">
				<img src="../icons/browse.png" class="img-buttons">
			</button>

			<button id="button-store" class="options">
				<img src="../icons/store.png" class="img-buttons">
			</button>
		</div>

		<form id="form-search" style="display: inline">
			<div id="div-search-bar">

				<input id="input-search-bar" type="text">

				<button id="button-magnifier">
					<img id="img-magnifier" src="../icons/magnifier.png" class="img-buttons">
				</button>
			</div>
		</form>

		<div id="div-secondary-buttons">
			<a href="../own-profile/own-profile.php" class="a-secondary-buttons" id="a-secondary-button-profile">
				<div class="div-img-secondary-buttons" id="div-secondary-button-profile">
					<img src="../icons/icon-profile-white.png" class="img-secondary-buttons" id="img-secondary-button-profile-white">
					<img src="../icons/icon-profile-green.png" class="img-secondary-buttons" id="img-secondary-button-profile-green">
				</div>
				<div class="div-secondary-buttons-text" id="div-secondary-button-profile-text">profile</div>
			</a>

			<a href="../library/library.php" class="a-secondary-buttons" id="a-secondary-button-library">
				<div class="div-img-secondary-buttons" id="div-secondary-button-library">
					<img src="../icons/icon-library-white.png" class="img-secondary-buttons" id="img-secondary-button-library-white">
					<img src="../icons/icon-library-green.png" class="img-secondary-buttons" id="img-secondary-button-library-green">
				</div>
				<div class="div-secondary-buttons-text" id="div-secondary-button-library-text">library</div>
			</a>

			<a href="../settings/settings.php" class="a-secondary-buttons" style="margin-left: 30px;" id="a-secondary-button-settings">
				<div class="div-img-secondary-buttons" id="div-secondary-button-settings">
					<img src="../icons/icon-settings-white.png" class="img-secondary-buttons" id="img-secondary-button-settings-white">
					<img src="../icons/icon-settings-green.png" class="img-secondary-buttons" id="img-secondary-button-settings-green">
				</div>
				<div class="div-secondary-buttons-text" id="div-secondary-button-settings-text">settings</div>
			</a>
		</div>

		<div id="div-profile">

			<div id="div-bpoints">
				<img src="../icons/bpoints.png" id="img-bpoints">
				<label id="label-bpoints"><?php echo $_SESSION["bpoints"] ?></label>
			</div>
			<div id="div-name-type">
				<label id="label-name"><?php echo $_SESSION["username"] ?></label><br>
				<label id="label-type" style="color: #674ea7 !important;"><?php echo $_SESSION["userType"] ?></label>
			</div>

			<img src="<?php echo $_SESSION["srcProfilePicture"] ?>" id="profile-picture">
		</div>

		<!--Header Secundario-->

		<nav id="nav-subtitle">
			<h2 id="h2-subtitle">STORE</h2>

			<button id="button-arrow">

				<img id="img-arrow" src="../icons/arrow.png" class="img-buttons">
				<h3 id="h3-filter">FILTER</h3>

			</button>
		</nav>

		<div id="div-filter">
			<div id="tags">
				<h4 id="h4-tags">Filter by tags</h4>
				<div id="div-column1">

					<input type="checkbox" id="3D-checkBox" class="input-checkbox"> <label id="3D-label">3D</label> <br>
					<input type="checkbox" id="Animation-checkBox" class="input-checkbox"> <label id="Animation-label">Animation</label> <br>
					<input type="checkbox" id="Anime-checkBox" class="input-checkbox"> <label id="Anime-label">Anime</label> <br>
					<input type="checkbox" id="Comics-checkBox" class="input-checkbox"> <label id="Comics-label">Comics</label> <br>
					<input type="checkbox" id="Emoji-checkBox" class="input-checkbox"> <label id="Emoji-label">Emoji</label> <br>
					<input type="checkbox" id="Horror-checkBox" class="input-checkbox"> <label id="Horror-label">Horror</label> <br>
					<input type="checkbox" id="DigitalArt-checkBox" class="input-checkbox"> <label id="DigitalArt-label">Digital Art</label>

				</div>

				<div id="div-column2">

					<input type="checkbox" id="Fractal-checkBox" class="input-checkbox"> <label id="Fractal-label">Fractal</label> <br>
					<input type="checkbox" id="PixelArt-checkBox" class="input-checkbox"> <label id="PixelArt-label">PixelArt</label> <br>
					<input type="checkbox" id="Photograpy-checkBox" class="input-checkbox"> <label id="Photograpy-label">Photograpy</label> <br>
					<input type="checkbox" id="StreetArt-checkBox" class="input-checkbox"> <label id="StreetArt-label">Street Art</label> <br>
					<input type="checkbox" id="Fantasy-checkBox" class="input-checkbox"> <label id="Fantasy-label">Fantasy</label> <br>
					<input type="checkbox" id="ScienceFiction-checkBox" class="input-checkbox"> <label id="ScienceFiction-label">Science Fiction</label> <br>
					<input type="checkbox" id="Wallpaper-checkBox" class="input-checkbox"> <label id="Wallpaper-label">Wallpaper</label>

				</div>
			</div>

			<input id="input-tags" name="tags" type="hidden" value="<?php echo $tags ?>">

			<div id="price">
				<h4 id="h4-price">Filter by price</h4>
				<h6 id="h6-price"><?php echo $maxPrice ?></h6>
				<input type="range" min="1" max="10000" value="<?php echo $maxPrice ?>" id="input-range-max-price" class="slider"><br>
			</div>
				<button id="button-refresh" class="button-submit">
					<div id="div-refresh">REFRESH</div>
				</button>
			</div>
	</header>


	<main id="main-general">

		<div id="div-carousel-bookmarkers">
			<button id="button-carousel-left" class="button-carousel">
				< </button> <button id="button-carousel-right" class="button-carousel"> >
			</button>
			<div id="div-carousel-images">
			</div>

		</div>

		<main id="main-images">
		</main>

	</main>

	<div id="div-pop-up-background"></div>

	<div id="div-pop-up">
		<div id="div-cancel-image">
			<img src="../icons/cancel.png" id="img-cancel-image">
		</div>
		<h4 class="h4-bookmark-delete">Are you sure you want to remove this image from your bookmark?</h4>
		<h4 id="id-image-to-delete" class="h4-bookmark-delete"></h4>
		<button id="button-bookmarks" class="button-submit">
			<div>REMOVE</div>
		</button>
	</div>

</body>
<script src="../jquery.js"></script>
<script src="carousel-bookmarks.js"></script>
<script src="../basic-functions.js"></script>
<script>
	var index = <?php echo $index ?>;
	var idUser = <?php echo $_SESSION["idUser"] ?>;
	var host = window.location["host"];

	/*Order Main Images*/

	window.onload = function() {

		var infoImages = <?php echo json_encode($infoImages) ?>;
		var maxIndex = <?php echo $_SESSION["maxIndex"]; ?>;

		/*Order Main Images*/

		if (window.screen.width > 1000) {
			orderImages("main-images", 200, 20, infoImages, index, maxIndex);
		} else if (window.screen.width > 500) {
			orderImages("main-images", 150, 15, infoImages, index, maxIndex);
		} else {
			orderImages("main-images", 100, 10, infoImages, index, maxIndex);
		}

		editHeader();

		/*Order Bookmarks*/

		var infoBookmarks = <?php echo json_encode($infoBookmarks) ?>;

		if (index == 1 && infoBookmarks.length > 0) {
			var buttonCancel;

			if (window.screen.width < 1100) {

				buttonCancel = ".button-delete-bookmarkers";

				for (var i = 0; i < infoBookmarks.length; i++) {
					listBookmarkers(infoBookmarks[i][1]);
				}

			} else {

				for (var i = 0; i < infoBookmarks.length; i++) {
					var imgBookmark = document.createElement('img');
					imgBookmark.src = infoBookmarks[i][0];
					imgBookmark.id = infoBookmarks[i][1];

					document.getElementById("div-carousel-images").appendChild(imgBookmark);
				}

				startCarousel(infoBookmarks);
				rotateCarousel();
				buttonCancel = ".div-delete-bookmark";

				$("#div-carousel-bookmarkers").css({
					opacity: "1"
				});

			}

			$(buttonCancel).click(function() {
				$("#div-pop-up-background").css("display", "block");
				$("#div-pop-up").css("display", "block");
				/*if(window.screen.width >= 1100){
					var idimageToDelete = "div-image-" + ($(this).attr("id")).slice(17);
					$("#id-image-to-delete").html(idimageToDelete);
				}*/
				var idImage = ($(this).attr("id")).split("-")[3];

				$("#button-bookmarks").click(function() {
					json = JSON.stringify({ action : "removeBookmark"});

					$.ajax({
						url: "http://"+host+":8888/api/action/" + idUser + "/" + idImage,
						Accept : "application/json",
						contentType: "application/json",
						type: 'POST',
						data: json,
						success: function(json) {
							location.reload();
						}
					});
				});

			});

		} else {
			$("#div-carousel-bookmarkers").css("display", "none");
			$("#div-button-arrow").css("display", "none");
			$("#main-images").css("margin-top", 0);
		}

	};

	var tagList = [];

	if ($("#input-tags").val() != "null") {
		tagList = $("#input-tags").val().split(',');
		for (var i = 0; i < tagList.length; i++) {
			$("#" + tagList[i] + "-checkBox").prop('checked', true);
			checkBoxState(tagList[i] + "-checkBox", "white", "#7c7c7c");
		}
	}

	$(".input-checkbox").click(function() {

		var idCheckBox = $(this).attr("id");

		if (!$(this).prop('checked')) {
			tagList.splice(tagList.indexOf(idCheckBox.split('-')[0]), 1);
			if (tagList.length == 0) {
				tagList == "null";
			}
		} else {
			tagList.push(idCheckBox.split('-')[0]);
		}

		$("#input-tags").val(tagList);

		window.location.href = "store.php?index=&tags=" + $("#input-tags").val() + "&maxPrice=" + $("#input-range-max-price").val();

	});

	$("#button-refresh").click(function() {
		window.location.href = "store.php?index=&tags=" + $("#input-tags").val() + "&maxPrice=" + $("#input-range-max-price").val();
	});

	/*consigue el id del div que contiene la imagen que se desea eliminar */
	/*Abrir popup y lista q reemplaza el carrousel*/

	function listBookmarkers(title) {
		console.log(title);
		var divBookmarkers = document.createElement('div');
		divBookmarkers.className = "div-delete-bookmarkers";

		var h2Bookmarkers = document.createElement('h2');
		h2Bookmarkers.className = "h2-name-image";
		h2Bookmarkers.textContent = title;

		var divContainsButtons = document.createElement('div');
		divContainsButtons.className = "div-contains-buttons-bookmarkers";

		var buttonBookmarkersView = document.createElement('button');
		buttonBookmarkersView.className = "button-view-bookmarkers";
		buttonBookmarkersView.id = "div-image-" + title;
		buttonBookmarkersView.textContent = "VIEW";

		var buttonBookmarkersDelete = document.createElement('button');
		buttonBookmarkersDelete.className = "button-delete-bookmarkers";
		buttonBookmarkersDelete.id = "button-delete-bookmarkers-" + title;
		buttonBookmarkersDelete.textContent = "DELETE";

		divBookmarkers.appendChild(h2Bookmarkers);
		divContainsButtons.appendChild(buttonBookmarkersView);
		divContainsButtons.appendChild(buttonBookmarkersDelete);
		divBookmarkers.appendChild(divContainsButtons);

		var divGeneral = document.getElementById("div-carousel-bookmarkers");
		divGeneral.appendChild(divBookmarkers);
	}

	/*salir popup*/

	$("#div-cancel-image").click(function() {
		$("#div-pop-up-background").css("display", "none");
		$("#div-pop-up").css("display", "none");
	});

	var inputRange = document.querySelector('#input-range-max-price');
	if (inputRange) {
		var h6Price = document.querySelector('#h6-price');
		if (h6Price) {
			h6Price.innerHTML = inputRange.value;

			inputRange.addEventListener('input', function() {
				h6Price.innerHTML = inputRange.value;
			}, false);
		}
	}

	if (<?php echo json_encode($openFilters) ?>) {
		changeArrow();
	}
</script>

</html>