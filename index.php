<?php
@include('helper.php');

$apiKey = "205bdba1c19c7dfdba1c19c7df";
$photos_dir = 'storage/photos';


if(isset($_GET['action']) && !empty($_GET['action'])){

	// validate api keys
	if(isset($_GET['apikey']) == false){
		echo "Invalid request";
		die();
	}


	switch ($_GET['action']) {
		case 'uploadTempPics':
			uploadTempPics($_POST);
			break;
		case 'saveTempPhoto':
			saveTempPhoto($_POST, $photos_dir);
			break;

		
		default:
			# code...
			break;
	}
}
function uploadTempPics($data)
{
	$maxsize = 2097152;
	$return;

	$photo_data = $data['photo_data'];
	$name_prefix = $data['name_prefix'];

    if($photo_data == null) {
    	return 'Data URL is missing!';
    }
    else
    {
    	findOrCreatePath('storage/temp');

		$sourcePath = base64_decode($photo_data);
		$filteredData=substr($photo_data, strpos($photo_data, ",")+1);

		$unencodedData=base64_decode($filteredData);

		$testpic = "storage/temp/".$name_prefix.uniqid().'.png';

		$sourcePath = fopen( $testpic, 'wb' );
		fwrite( $sourcePath, $unencodedData);
		fclose( $sourcePath );

		echo $testpic;
    }

}

function saveTempPhoto($data, $photos_dir){

	findOrCreatePath($photos_dir);

	$photo = json_decode($data['temp_photo']);
	$name_prefix = $data['name_prefix'];
	$new_name = $photos_dir.'/'.$name_prefix.uniqid().'.png';

	copy($photo->path, $new_name);
    unlink(removeServerDomainFromStr($photo->path));

    echo $new_name;
}

function removeServerDomainFromStr($str){
	$serverdomain = 'http://localhost/unick-file-server/';
	return explode($serverdomain, $str)[1];
}