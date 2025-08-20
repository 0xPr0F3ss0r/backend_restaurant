<?php
define("MB", 1048576);


function UploadFileUpdateInfo($RequestImage, $Type)
{
    global $msgerror;
    // Check if file was uploaded
    if (!isset($_FILES["userImage"]) || $_FILES[$RequestImage]['error'] !== UPLOAD_ERR_OK) {
        $msgerror = "upload_err";
        return "FAIL1";
    }

    $originalName = $_FILES[$RequestImage]['name'];
    $imagetmp = $_FILES[$RequestImage]['tmp_name'];
    $imagesize = $_FILES[$RequestImage]['size'];

    // Define allowed extensions with proper MIME type checking
    $allowedExtensions = ["png", "jpg", "jpeg", "gif", "mp3", "pdf"];
    $allowedMimeTypes = [
        "png" => "image/png",
        "jpg" => "image/jpeg",
        "jpeg" => "image/jpeg",
        "gif" => "image/gif",
        "mp3" => "audio/mpeg",
        "pdf" => "application/pdf"
    ];

    // Get file extension
    $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    // Validate extension
    if (!in_array($extension, $allowedExtensions)) {
        $msgerror = "invalid_extension";
        return "FAIL2";
    }

    // Validate MIME type for additional security
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $imagetmp);
    finfo_close($finfo);

    if (!isset($allowedMimeTypes[$extension]) || $mimeType !== $allowedMimeTypes[$extension]) {
        $msgerror = "invalid_mime_type";
        return "FAIL3";
    }

    // Check file size (10MB limit)
    $maxSize = 10 * 1024 * 1024;
    if ($imagesize > $maxSize) {
        $msgerror = "file_too_large";
        return "FAIL4";
    }

    // Validate and sanitize the Type parameter
    $Type = preg_replace('/[^a-zA-Z0-9_-]/', '', $Type);
    if (empty($Type)) {
        $msgerror = "invalid_type";
        return "FAIL5";
    }

    // Create upload directory path
    $upload_dir = 'C:/xampp/htdocs/restaurant_backend/upload/' . $Type . '/';

    // Create directory if it doesn't exist
    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0755, true)) {
            $msgerror = "directory_creation_failed";
            return "FAIL6";
        }
    }

    // Generate secure filename
    $filename = bin2hex(random_bytes(16)) . '.' . $extension;
    $destination = $upload_dir . $filename;

    // Ensure filename is unique (prevent overwriting)
    $counter = 1;
    while (file_exists($destination)) {
        $filename = bin2hex(random_bytes(16)) . '_' . $counter . '.' . $extension;
        $destination = $upload_dir . $filename;
        $counter++;
    }

    // Move uploaded file
    if (move_uploaded_file($imagetmp, $destination)) {
        // Set appropriate file permissions
        chmod($destination, 0644);
        return $filename;
    } else {
        $msgerror = "move_failed";
        return "FAIL7";
    }
}
function fliterRequest($Requestname)
{
    return htmlspecialchars(strip_tags($_POST[$Requestname] ?? ''));
}

function UploadFileOrder($RequestImage, $Type)
{
    global $msgerror;
    // Check if file was uploaded
    if (!isset($_FILES["orderImage"]) || $_FILES[$RequestImage]['error'] !== UPLOAD_ERR_OK) {
        $msgerror = "upload_err";
        return "FAIL1";
    }

    $originalName = $_FILES[$RequestImage]['name'];
    $imagetmp = $_FILES[$RequestImage]['tmp_name'];
    $imagesize = $_FILES[$RequestImage]['size'];

    // Define allowed extensions with proper MIME type checking
    $allowedExtensions = ["png", "jpg", "jpeg", "gif", "mp3", "pdf"];
    $allowedMimeTypes = [
        "png" => "image/png",
        "jpg" => "image/jpeg",
        "jpeg" => "image/jpeg",
        "gif" => "image/gif",
        "mp3" => "audio/mpeg",
        "pdf" => "application/pdf"
    ];

    // Get file extension
    $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    // Validate extension
    if (!in_array($extension, $allowedExtensions)) {
        $msgerror = "invalid_extension";
        return "FAIL2";
    }

    // Validate MIME type for additional security
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $imagetmp);
    finfo_close($finfo);

    if (!isset($allowedMimeTypes[$extension]) || $mimeType !== $allowedMimeTypes[$extension]) {
        $msgerror = "invalid_mime_type";
        return "FAIL3";
    }

    // Check file size (10MB limit)
    $maxSize = 10 * 1024 * 1024;
    if ($imagesize > $maxSize) {
        $msgerror = "file_too_large";
        return "FAIL4";
    }

    // Validate and sanitize the Type parameter
    $Type = preg_replace('/[^a-zA-Z0-9_-]/', '', $Type);
    if (empty($Type)) {
        $msgerror = "invalid_type";
        return "FAIL5";
    }

    // Create upload directory path
    $upload_dir = 'C:/xampp/htdocs/restaurant_backend/upload/' . $Type . '/';

    // Create directory if it doesn't exist
    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0755, true)) {
            $msgerror = "directory_creation_failed";
            return "FAIL6";
        }
    }

    // Generate secure filename
    $filename = bin2hex(random_bytes(16)) . '.' . $extension;
    $destination = $upload_dir . $filename;

    // Ensure filename is unique (prevent overwriting)
    $counter = 1;
    while (file_exists($destination)) {
        $filename = bin2hex(random_bytes(16)) . '_' . $counter . '.' . $extension;
        $destination = $upload_dir . $filename;
        $counter++;
    }

    // Move uploaded file
    if (move_uploaded_file($imagetmp, $destination)) {
        // Set appropriate file permissions
        chmod($destination, 0644);
        return $filename;
    } else {
        $msgerror = "move_failed";
        return "FAIL7";
    }
}
function UploadFile($RequestImage, $Type)
{
    global $msgerror;
    // Check if file was uploaded
    if (!isset($_FILES["orderImage"]) || $_FILES[$RequestImage]['error'] !== UPLOAD_ERR_OK) {
        $msgerror = "upload_err";
        return "FAIL1";
    }

    $originalName = $_FILES[$RequestImage]['name'];
    $imagetmp = $_FILES[$RequestImage]['tmp_name'];
    $imagesize = $_FILES[$RequestImage]['size'];

    // Define allowed extensions with proper MIME type checking
    $allowedExtensions = ["png", "jpg", "jpeg", "gif", "mp3", "pdf"];
    $allowedMimeTypes = [
        "png" => "image/png",
        "jpg" => "image/jpeg",
        "jpeg" => "image/jpeg",
        "gif" => "image/gif",
        "mp3" => "audio/mpeg",
        "pdf" => "application/pdf"
    ];

    // Get file extension
    $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    // Validate extension
    if (!in_array($extension, $allowedExtensions)) {
        $msgerror = "invalid_extension";
        return "FAIL2";
    }

    // Validate MIME type for additional security
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $imagetmp);
    finfo_close($finfo);

    if (!isset($allowedMimeTypes[$extension]) || $mimeType !== $allowedMimeTypes[$extension]) {
        $msgerror = "invalid_mime_type";
        return "FAIL3";
    }

    // Check file size (10MB limit)
    $maxSize = 10 * 1024 * 1024;
    if ($imagesize > $maxSize) {
        $msgerror = "file_too_large";
        return "FAIL4";
    }

    // Validate and sanitize the Type parameter
    $Type = preg_replace('/[^a-zA-Z0-9_-]/', '', $Type);
    if (empty($Type)) {
        $msgerror = "invalid_type";
        return "FAIL5";
    }

    // Create upload directory path
    $upload_dir = 'C:/xampp/htdocs/restaurant_backend/upload/' . $Type . '/';

    // Create directory if it doesn't exist
    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0755, true)) {
            $msgerror = "directory_creation_failed";
            return "FAIL6";
        }
    }

    // Generate secure filename
    $filename = bin2hex(random_bytes(16)) . '.' . $extension;
    $destination = $upload_dir . $filename;

    // Ensure filename is unique (prevent overwriting)
    $counter = 1;
    while (file_exists($destination)) {
        $filename = bin2hex(random_bytes(16)) . '_' . $counter . '.' . $extension;
        $destination = $upload_dir . $filename;
        $counter++;
    }

    // Move uploaded file
    if (move_uploaded_file($imagetmp, $destination)) {
        // Set appropriate file permissions
        chmod($destination, 0644);
        return $filename;
    } else {
        $msgerror = "move_failed";
        return "FAIL7";
    }
}

function UploadFileFood($RequestImage, $Type)
{
    global $msgerror;
    // Check if file was uploaded
    if (!isset($_FILES["FoodImage"]) || $_FILES[$RequestImage]['error'] !== UPLOAD_ERR_OK) {
        $msgerror = "upload_err";
        return "FAIL1";
    }

    $originalName = $_FILES[$RequestImage]['name'];
    $imagetmp = $_FILES[$RequestImage]['tmp_name'];
    $imagesize = $_FILES[$RequestImage]['size'];

    // Define allowed extensions with proper MIME type checking
    $allowedExtensions = ["png", "jpg", "jpeg", "gif", "mp3", "pdf"];
    $allowedMimeTypes = [
        "png" => "image/png",
        "jpg" => "image/jpeg",
        "jpeg" => "image/jpeg",
        "gif" => "image/gif",
        "mp3" => "audio/mpeg",
        "pdf" => "application/pdf"
    ];

    // Get file extension
    $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    // Validate extension
    if (!in_array($extension, $allowedExtensions)) {
        $msgerror = "invalid_extension";
        return "FAIL2";
    }

    // Validate MIME type for additional security
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $imagetmp);
    finfo_close($finfo);

    if (!isset($allowedMimeTypes[$extension]) || $mimeType !== $allowedMimeTypes[$extension]) {
        $msgerror = "invalid_mime_type";
        return "FAIL3";
    }

    // Check file size (10MB limit)
    $maxSize = 10 * 1024 * 1024;
    if ($imagesize > $maxSize) {
        $msgerror = "file_too_large";
        return "FAIL4";
    }

    // Validate and sanitize the Type parameter
    $Type = preg_replace('/[^a-zA-Z0-9_-]/', '', $Type);
    if (empty($Type)) {
        $msgerror = "invalid_type";
        return "FAIL5";
    }

    // Create upload directory path
    $upload_dir = 'C:/xampp/htdocs/restaurant_backend/upload/' . $Type . '/';

    // Create directory if it doesn't exist
    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0755, true)) {
            $msgerror = "directory_creation_failed";
            return "FAIL6";
        }
    }

    // Generate secure filename
    $filename = bin2hex(random_bytes(16)) . '.' . $extension;
    $destination = $upload_dir . $filename;

    // Ensure filename is unique (prevent overwriting)
    $counter = 1;
    while (file_exists($destination)) {
        $filename = bin2hex(random_bytes(16)) . '_' . $counter . '.' . $extension;
        $destination = $upload_dir . $filename;
        $counter++;
    }

    // Move uploaded file
    if (move_uploaded_file($imagetmp, $destination)) {
        // Set appropriate file permissions
        chmod($destination, 0644);
        return $filename;
    } else {
        $msgerror = "move_failed";
        return "FAIL7";
    }
}


function DeleteFile($dir, $imagename)
{
    if (file_exists($dir . "/" . $imagename)) {
        unlink($dir . "/" . $imagename);
    }
}

function UploadFileSpecial($RequestImage, $Type)
{
    global $msgerror;

    // Check if file was uploaded
    if (!isset($_FILES["SpecialOfferImage"]) || $_FILES[$RequestImage]['error'] !== UPLOAD_ERR_OK) {
        $msgerror = "upload_err";
        return "FAIL1";
    }

    $originalName = $_FILES[$RequestImage]['name'];
    $imagetmp = $_FILES[$RequestImage]['tmp_name'];
    $imagesize = $_FILES[$RequestImage]['size'];

    // Define allowed extensions with proper MIME type checking
    $allowedExtensions = ["png", "jpg", "jpeg", "gif", "mp3", "pdf"];
    $allowedMimeTypes = [
        "png" => "image/png",
        "jpg" => "image/jpeg",
        "jpeg" => "image/jpeg",
        "gif" => "image/gif",
        "mp3" => "audio/mpeg",
        "pdf" => "application/pdf"
    ];

    // Get file extension
    $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    // Validate extension
    if (!in_array($extension, $allowedExtensions)) {
        $msgerror = "invalid_extension";
        return "FAIL2";
    }

    // Validate MIME type for additional security
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $imagetmp);
    finfo_close($finfo);

    if (!isset($allowedMimeTypes[$extension]) || $mimeType !== $allowedMimeTypes[$extension]) {
        $msgerror = "invalid_mime_type";
        return "FAIL3";
    }

    // Check file size (10MB limit)
    $maxSize = 10 * 1024 * 1024;
    if ($imagesize > $maxSize) {
        $msgerror = "file_too_large";
        return "FAIL4";
    }

    // Validate and sanitize the Type parameter
    $Type = preg_replace('/[^a-zA-Z0-9_-]/', '', $Type);
    if (empty($Type)) {
        $msgerror = "invalid_type";
        return "FAIL5";
    }

    // Create upload directory path
    $upload_dir = 'C:/xampp/htdocs/restaurant_backend/upload/' . $Type . '/';

    // Create directory if it doesn't exist
    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0755, true)) {
            $msgerror = "directory_creation_failed";
            return "FAIL6";
        }
    }

    // Generate secure filename
    $filename = bin2hex(random_bytes(16)) . '.' . $extension;
    $destination = $upload_dir . $filename;

    // Ensure filename is unique (prevent overwriting)
    $counter = 1;
    while (file_exists($destination)) {
        $filename = bin2hex(random_bytes(16)) . '_' . $counter . '.' . $extension;
        $destination = $upload_dir . $filename;
        $counter++;
    }

    // Move uploaded file
    if (move_uploaded_file($imagetmp, $destination)) {
        // Set appropriate file permissions
        chmod($destination, 0644);
        return $filename;
    } else {
        $msgerror = "move_failed";
        return "FAIL7";
    }
}
function UploadFileBest($RequestImage, $Type)
{
    global $msgerror;
    // Check if file was uploaded
    if (!isset($_FILES["BestOfferImage"]) || $_FILES[$RequestImage]['error'] !== UPLOAD_ERR_OK) {
        $msgerror = "upload_err";
        return "FAIL1";
    }

    $originalName = $_FILES[$RequestImage]['name'];
    $imagetmp = $_FILES[$RequestImage]['tmp_name'];
    $imagesize = $_FILES[$RequestImage]['size'];

    // Define allowed extensions with proper MIME type checking
    $allowedExtensions = ["png", "jpg", "jpeg", "gif", "mp3", "pdf"];
    $allowedMimeTypes = [
        "png" => "image/png",
        "jpg" => "image/jpeg",
        "jpeg" => "image/jpeg",
        "gif" => "image/gif",
        "mp3" => "audio/mpeg",
        "pdf" => "application/pdf"
    ];

    // Get file extension
    $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    // Validate extension
    if (!in_array($extension, $allowedExtensions)) {
        $msgerror = "invalid_extension";
        return "FAIL2";
    }

    // Validate MIME type for additional security
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $imagetmp);
    finfo_close($finfo);

    if (!isset($allowedMimeTypes[$extension]) || $mimeType !== $allowedMimeTypes[$extension]) {
        $msgerror = "invalid_mime_type";
        return "FAIL3";
    }

    // Check file size (10MB limit)
    $maxSize = 10 * 1024 * 1024;
    if ($imagesize > $maxSize) {
        $msgerror = "file_too_large";
        return "FAIL4";
    }

    // Validate and sanitize the Type parameter
    $Type = preg_replace('/[^a-zA-Z0-9_-]/', '', $Type);
    if (empty($Type)) {
        $msgerror = "invalid_type";
        return "FAIL5";
    }

    // Create upload directory path
    $upload_dir = 'C:/xampp/htdocs/restaurant_backend/upload/' . $Type . '/';

    // Create directory if it doesn't exist
    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0755, true)) {
            $msgerror = "directory_creation_failed";
            return "FAIL6";
        }
    }

    // Generate secure filename
    $filename = bin2hex(random_bytes(16)) . '.' . $extension;
    $destination = $upload_dir . $filename;

    // Ensure filename is unique (prevent overwriting)
    $counter = 1;
    while (file_exists($destination)) {
        $filename = bin2hex(random_bytes(16)) . '_' . $counter . '.' . $extension;
        $destination = $upload_dir . $filename;
        $counter++;
    }

    // Move uploaded file
    if (move_uploaded_file($imagetmp, $destination)) {
        // Set appropriate file permissions
        chmod($destination, 0644);
        return $filename;
    } else {
        $msgerror = "move_failed";
        return "FAIL7";
    }
}
function checkAuthenticate()
{
    if (isset($_SERVER['PHP_AUTH_USER'])  && isset($_SERVER['PHP_AUTH_PW'])) {

        if ($_SERVER['PHP_AUTH_USER'] != AUTH_USER ||  $_SERVER['PHP_AUTH_PW'] != AUTH_PASS) {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Page Not Found';
            exit;
        }
    } else {
        exit;
    }
}

function printfail($error = "none")
{
    echo json_encode(array('status' => "failure", 'message' => $error));
}

function printsucuss($msg)
{
    echo json_encode(array('status' => "success", 'message' => $msg));
}

function sendMail($to, $subject, $message)
{
    $header = "FROM: " . MAIL_FROM;
    mail($to, $subject, $message, $header);
    echo "success";
}

function result($count, $msg, $error)
{
    if ($count > 0) {
        printsucuss($msg);
    } else {
        printfail($error);
    }
}

function hashPassword($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

function verifyPassword($password, $hash)
{
    return password_verify($password, $hash);
}
