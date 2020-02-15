function showInfoDialog(message) {
    $("#infoModal #modal-message").text(message);

    $("#infoModal").modal("show");
}

function hideInfoDialog(message) {
    $("#infoModal").modal("hide");
}

function showConfirmationDialog(message, positiveFunction) {
    $("#confirmModal #modal-message").html(message);

    //set positive on click listener
    $("#confirmModal #positive").on("click", function() {
        $("#confirmModal").modal("hide");
        positiveFunction();
    });

    $("#confirmModal").modal("show");
}

function hideConfirmationDialog() {
    $("#confirmModal").modal("hide");
}

function showProgress() {
    $(".progress-screen").css("display", "block");
}
function hideProgress() {
    $(".progress-screen").css("display", "none");
}

function borrowBook(id) {
    showProgress();
    axios
        .get("/request/make/" + id)
        .then(function(response) {
            hideProgress();
            console.log(response.data.mssg);
            console.log(response.status);
            if (response.status == 200) {
                showInfoDialog(response.data.mssg);
                $("#" + id + "-borrow").prop("disabled", "disabled");
            } else {
                showInfoDialog(response.data.mssg);
                console.log();
            }
        })
        .catch(function(error) {
            hideProgress();
            showInfoDialog("Sorry there was an error requesting for the book");
        });
}

function grantRequest(id) {
    showProgress();
    axios
        .get("/request/grant/" + id)
        .then(function(response) {
            hideProgress();
            console.log(response.data);
            console.log(response.status);
            if (response.status == 200) {
                showInfoDialog(response.data.mssg);
                $("#" + id + "-grant").prop("disabled", "disabled");
                //refreshing after 3 secs
                setTimeout(function() {
                    location.reload();
                }, 3000);
            } else {
                showInfoDialog(response.data.mssg);
                console.log();
            }
        })
        .catch(function(error) {
            hideProgress();
            showInfoDialog("Sorry there was an error granting request");
        });
}
