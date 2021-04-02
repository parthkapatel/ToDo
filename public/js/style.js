function renderObjectToHtml(dataResult){
    let val = "";
    if(dataResult.length > 0){
        for (let i = 0; i < dataResult.length; i++) {
            let data = "";
            let icon = "";
            let star = "";
            if (dataResult[i]["mark_as_read"] === 1) {
                data = "<strike><h5 class='font-weight-bold' >" + dataResult[i]["title"] + "</h5></strike>" +
                    "                                    <strike><p>" + ((dataResult[i]["notes"] === null) ? "" : dataResult[i]["notes"]) + "</p></strike>";

            } else {
                data = "<h5 class='font-weight-bold' >" + dataResult[i]["title"] + "</h5>" +
                    "                                    <p>" + ((dataResult[i]["notes"] === null) ? "" : dataResult[i]["notes"]) + "</p>";
            }

            if (dataResult[i]["mark_as_favorite"] === 1) {
                star = "<i class='fa fa-star star' id='" + dataResult[i]["id"] + "' aria-hidden='true' title='Mark as favorite' style='cursor: pointer;'></i>";
            } else {
                star = "<i class='far fa-star star' id='" + dataResult[i]["id"] + "' aria-hidden='true' title='Mark as favorite' style='cursor: pointer;'></i>";
            }

            if (dataResult[i]["mark_as_read"] === 1) {
                icon = "<i class='fa fa-times rightIcon text-danger' title='Mark as unread' aria-hidden='true' id='" + dataResult[i]["id"] + "' style='cursor: pointer;'></i>";
            } else {
                icon = "<i class='fa fa-check rightIcon text-success' title='Mark as read' aria-hidden='true' id='" + dataResult[i]["id"] + "' style='cursor: pointer;'></i>";
            }

            val += "<div class='container  d-flex justify-content-between border-bottom align-items-center' data-id='" + dataResult[i]["task_order"] + "' id='" + dataResult[i]["id"] + "'>" +
                "       <div class='d-flex justify-content-around align-items-center' style='width:100px;'>" +
                "            <img src='/img/5122363301556277312-128.png' width='32px' height='32px' alt='drag' style='cursor:move'/>" +
                "               <input type='radio' id='" + dataResult[i]["id"] + "' class='check' name='check' value='" + dataResult[i]["id"] + "'>" +
                "       </div>" +
                "       <div class='container p-2' id='content'>"
                + data +
                "</div>" +
                "       <div class='text-center'>"
                + star + icon +
                "</div>" +
                "     </div>";

        }
    }else{
        val = "<h3 class='container text-danger text-center'>No Data</h3>";
    }

    return val;
}





function getdata() {
    $.ajax({
        url: "/get",
        type: "GET",
        cache: false,
        success: function (dataResult) {
            let val = renderObjectToHtml(dataResult);
            $("#subDiv").html(val);
        }
    });
}


function clearFormFields() {
    $("#title").val("");
    $("#startDate").val("");
    $("#dueDate").val("");
    $("#notes").val("");
    $(".form").attr("id", "/store");
}


window.onload = getdata();

$(document).ready(function () {
    let id = null;

    $(document).on("change", ".check", function () {
        if ($(this).data('checked', true)) {
            id = $(this).val();

            $("#selectTitle").hide();

            $.ajax({
                url: "/task/" + id + "/edit",
                type: "GET",
                cache: false,
                success: function (dataResult) {
                    $("#title").val(dataResult["title"]);
                    $("#startDate").val(dataResult["start_date"]);
                    $("#dueDate").val(dataResult["due_date"]);
                    $("#dueDate").attr("min", dataResult["start_date"]);
                    $("#notes").val(dataResult["notes"]);
                    $(".form").attr("id", "/task/" + id + "/update");
                    $("#formDiv").show();
                    if (dataResult["mark_as_favorite"]) {
                        $("#star").removeClass("bi bi-star text-white p-2");
                        $("#star").addClass("bi bi-star-fill text-warning p-2");
                    } else {
                        $("#star").removeClass("bi bi-star-fill text-warning p-2");
                        $("#star").addClass("bi bi-star text-white p-2");
                    }
                    $("#star").show();
                    $("#trash").show();
                }
            });
        }
    });

    $(function () {
        $("#subDiv").sortable({
            connectWith: '.sortable',
            update: function (event, ui) {
                var idsInOrder = $("#subDiv").sortable('toArray', {attribute: 'id'});
                $.ajax({
                    url: "/task/arrangeOrder",
                    type: "GET",
                    cache: false,
                    data: {
                        "orders": idsInOrder
                    },
                    success: function (dataResult) {
                        getdata();
                    }
                });
            }
        });
        $("#subDiv").disableSelection();
    });

    $("#btnAdd").on("click", function () {
        $("#star").hide();
        $("#trash").hide();
        $("#selectTitle").hide();
        clearFormFields();
        $("#formDiv").show();
    });

    $(document).on('click', ".star", function () {
        if ($(this).data('click', true)) {
            var id1 = $(this).attr("id");
        }
        $.ajax({
            url: "/task/" + id1 + "/mark-as-favorite",
            type: "GET",
            cache: false,
            success: function (dataResult) {
                getdata();
            }
        });
    });

    $("#trash").on('click', function () {
        $.ajax({
            url: "/task/" + id + "/delete",
            type: "GET",
            cache: false,
            success: function (dataResult) {
                clearFormFields();

                getdata();
            }
        });
    });

    $(document).on('click', ".rightIcon", function () {
            let id1;
            if ($(this).data('click', true)) {
                id1 = $(this).attr("id");
            }
            $.ajax({
                url: "/task/" + id1 + "/mark-as-read",
                type: "GET",
                cache: false,
                success: function (dataResult) {
                    getdata();
                }
            });
        }
    );

    $("#startDate").on("click", function () {
        const d = new Date();
        const month = d.getMonth() + 1;
        const day = d.getDate();
        const output = d.getFullYear() + '-' +
            (month < 10 ? '0' : '') + month + '-' +
            (day < 10 ? '0' : '') + day;
        $("#startDate").attr("min", output);
    });

    $("#startDate").on("change", function () {
        $("#dueDate").attr("min", $("#startDate").val());
    });

    $("#addData").on("click",function (){
        let action = $(".form").attr("id");
        $.ajax({
            url: action,
            type: "POST",
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{
                "title" : $("#title").val(),
                "startDate" : $("#startDate").val(),
                "dueDate" : $("#dueDate").val(),
                "notes" : $("#notes").val()
            },
            success: function (dataResult) {
                clearFormFields()
                $("#formDiv").hide();
                $("#selectTitle").show();
                getdata();
            }
        });
    });

    $(document).on("keyup","#search",function () {
        $.ajax({
            url: "/task/search",
            type: "GET",
            cache: false,
            data:{
                "search" : $("#search").val()
            },
            success: function (dataResult) {
                let val = renderObjectToHtml(dataResult);
                $("#subDiv").html(val);
            }
        });
    });
});
