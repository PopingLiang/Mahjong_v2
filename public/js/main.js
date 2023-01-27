$(function() {
    //增加內容單項
    $(".cus-btn-add button").on("click", function() {
        console.log(this)
        var item = $(this.parentElement).prop('outerHTML');
        $(this).parents(".cus-btn-add").append(item);
    })

    //增加副標內容
    $("button.cus-sub-obj").on("click",function(){
        var id=$(this).data().li
        $("#"+id).append($("#"+id).children().prop('outerHTML'))
        //console.log($("#"+id).children().prop('outerHTML'))
    })

    $("#birth").on("change", function() {
        var birth = $(this).val().split("-")
        birth[0] = birth[0] - 1911
        $("#sun-birth").val("民國"+birth[0]+"年 "+birth[1]+"月 "+birth[2]+"日")
    })
})


//變形增加 在事項那邊
function addTelTrancelate(obj){
    console.log(obj)
    Swal.fire({
        html:`
        <div id="tel-mobile" class="cus-btn-add">
            <div class="input-group mb-3">
                <span class="input-group-text">電話</span>
                <input type="tel" class="form-control" name="tel[]">
                <button class="btn btn-outline-secondary" type="button" onclick="addtel(this)">增加</button>
            </div>
        </div>`
    }).then((result) => {
        if (result.isConfirmed) {
            $(obj).parents(".cus-btn-add-trancelat").children().children("input").val($("[name=tel\\[\\]]").map(function() {
                return this.value;
              })
              .get()
              .join());
        }
    })
}

function addtel(obj){
    console.log(obj)
        var item = $(obj.parentElement).prop('outerHTML');
        $(obj).parents(".cus-btn-add").append(item);
}

function Fajax(url){
    data=$( "form" ).serialize()
    $.ajax({
        url: url,
        data: data,
        dataType: "text",
        type: "POST",
        success: function(result) {
            console.log(result)
        }

    })
}
   