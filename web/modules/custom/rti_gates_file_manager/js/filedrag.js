(function($) {

    var uploadedFile;
    var dropAreaForm;

    // file drag hover
    function FileDragHover(e) {

        e.stopPropagation();
        e.preventDefault();
        e.target.className = (e.type == "dragover" ? "hover" : "");
    }

    // file selection
    function FileSelectHandler(e) {

        console.log(e);
        // cancel event and hover styling
        FileDragHover(e);

        // fetch FileList object
        var files = e.target.files || e.originalEvent.dataTransfer.files;

        console.log(files);
        uploadedFile = files;

        // process all File objects
        for (var i = 0, f; f = files[i]; i++) {
            ParseFile(f);
        }
    }

    // output information
    function Output(msg) {
        var m = $("#fileListArea");
        dropAreaForm = $("#fileListArea").html();
        // m.html(msg);
        m.append(msg);
    }

    // output file information
    function ParseFile(file) {

        var reader = new FileReader();
        reader.onload = function() {
            Output(
                "<p>" + file.name + "</p>"
            );
        }
        reader.readAsText(file);
    }

    function FileSelectUpload(e) {

        // cancel event and hover styling
        FileDragHover(e);

        // fetch FileList object
        //var files = fileObj.target.files || fileObj.originalEvent.dataTransfer.files;
        var files = uploadedFile;

        // process all File objects
        for (var i = 0, f; f = files[i]; i++) {
            console.log(f);
            console.log(f.__proto__.__proto__);
            UploadFile(f);
        }
    }

    function UploadFile(file) {

        var fd = new FormData();
        fd.append('file', file);

        $.ajax({
            url: '/fortesting/web/rti_gates_file_manager/upload',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response) {
                let result = response.success;
                if (result) {

                    $("#fileUploadWrapper").fadeOut(500, function() {

                        resetFile();

                        $('html, body').css({
                            'overflow': 'auto',
                            'height': 'auto'
                        });
                    });
                } else {
                    let msg = response.message;
                    alert('file not uploaded: ' + msg);
                }
            }
        });
    }

    function createForm() {

        var formHtml = '<div id="fileUploadWrapper" class="uploadFormHolder"><div id="uploadFilesText">Upload Files</div>' +
            '<form id="cardBgUploadFrm" name="cardBgUploadFrm" enctype="multipart/form-data" style="margin:0px;">' +
            '<div style="overflow:auto;"><div id="dropArea" style="float:left"><div style="text-align:center;font-weight: bold;top:100px; position:relative;">' +
            'Drag and Drop file here <br />or<br /><label for="bgFile" id="browsebtn">Browse</label><input id="bgFile" name="bgFile" type="file" size="40" value="bgFile" /></div></div>' +
            '<div id="fileListArea"></div></div><div style="width:100%; height:35px;">' +
            '<select id="dropdown"></select><input id="saveUploadFile" type="submit" name="submit" title="submit" value="Upload" tabindex="15" class="btn" style="float:right"/>' +
            '<button id="cancel" value="Cancel" name="Cancel" tabindex="14" class="btn" style="float:left;">Cancel</button></div></form></div>';

        $("body").append(formHtml);
    }

    // initialize
    function resetFile() {

        $("#fileUploadWrapper").fadeOut(500);
        $("#fileListArea").html(dropAreaForm); //reset the form

        uploadedFile = [];

        var dropArea = $("#dropArea");
        var saveUploadFile = $("#saveUploadFile");

        // is XHR2 available?
        var xhr = new XMLHttpRequest();

        if (xhr.upload) {
            // file drop
            dropArea.bind("dragover", FileDragHover);
            dropArea.bind("dragleave", FileDragHover);
            dropArea.bind("drop", FileSelectHandler);
            saveUploadFile.bind("click", FileSelectUpload);
            dropArea.css("display", "block");

        }
    }

    // initialize
    function Init() {

        createForm();

        var bgFile = $("#bgFile");
        var dropArea = $("#dropArea");
        var saveUploadFile = $("#saveUploadFile");
        var cancelButton = $("#cancel");

        // file select
        bgFile.bind("change", FileSelectHandler);

        // is XHR2 available?
        var xhr = new XMLHttpRequest();

        if (xhr.upload) {

            // file drop
            dropArea.bind("dragover", FileDragHover);
            dropArea.bind("dragleave", FileDragHover);
            dropArea.bind("drop", FileSelectHandler);
            saveUploadFile.bind("click", FileSelectUpload);
            dropArea.css("display", "block");

        }

        cancelButton.click(function(e) {

            e.preventDefault();

            resetFile();

            $('html, body').css({
                'overflow': 'auto',
                'height': 'auto'
            });
        });
    }

    function dropdown() {

        $.ajax({
            url: "/fortesting/web/rti_gates_file_manager/getDirectories",
            type: 'GET',
            success: function(response) {
                data = response.data;
                console.log(response);
                alert(response);
            }
        });


        var option = document.createElement("option");
        option.text = "Test";
        var option2 = document.createElement("option");
        option2.text = "Another Test";
        document.getElementById("dropdown").add(option);
        document.getElementById("dropdown").add(option2);
    }

    // call initialization file
    if (window.File && window.FileList && window.FileReader) {

        Init();
        dropdown();

    }

}(jQuery, Drupal));