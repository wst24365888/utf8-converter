<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>UTF-8 Converter</title>
</head>
<body>
    <form id="upload_form">
        <input type="file" id="upload_file" />
        <button type="button" id="upload_button">Upload</button>
    </form>
</body>
</html>

<script
    src="https://code.jquery.com/jquery-3.6.0.js"
    integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous">
</script>

<script type="text/javascript">
    $("#upload_button").on("click", function () {
        var formData = new FormData();
        var files = $('#upload_file')[0].files;

        if(files.length == 0) {
            alert("Please select a file.");
            return;
        }

        formData.append('file', files[0]);

        $.ajax({
            method: "POST",
            url: "/uploaded_file",
            data: formData,
            processData: false,
            contentType : false,
        }).done(function (response) {
            console.log(response);

            if(response["success"]) {
                alert("File uploaded.");

                // Download the file.
                window.location.href = "/uploaded_file/" + response["file_id"];

                // Delete the file.
                // $.ajax({
                //     method: "DELETE",
                //     url: "/uploaded_file/" + response["file_id"],
                // }).done(function (response) {
                //     console.log(response);
                // });
            } else {
                alert(response["message"]["file"]);
            }
        });
    });
</script>