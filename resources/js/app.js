const { get } = require('lodash');

require('./bootstrap');

$(document).ready(function(){

    if((document.URL).search("edit") < 0){
        $.ajax({
            url:'/fetch_id',
            type:'GET',
            success:function(data){
                data = $.parseJSON(data);
                $("#cust_id").val(data.cust_id);
                $("#prod_id").val(data.prod_id);
            }
        });
    }
    $("#cust_data").change(function(){
        var options = "<option selected disabled value=''>Product Code</option>";
        
        $.ajax({
            url:'/get_prod/'+this.value,
            type:'GET',
            success:function(data){
                data = $.parseJSON(data);
                if(data.length == 0){
                    alert("No Transactions for this customer, Please select any other customer")
                    $("#cust_data").focus();
                }
                else{
                    options += "<option value='all'>All</option>";
                    $.each(data, function(index, value){
                        options += "<option value="+value.id+">"+value.name+"</option>";
                        // Set the options value with the response from the get_prod API
                    });
                }
                $("#product-list").html(options);
            }
        });
    });

    $(".delete_button").click(function(e){        
        $('#confirmation-form').modal('toggle');
        $('.delete_form').attr('id',this.id);
    });

    $(".delete_form").submit(function(e){
        e.preventDefault();
        var str = this.id;
        var arr = str.split('-');
        var url = arr[1]+'/'+arr[2];
        // console.log(url);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:url,
            type:'DELETE',
            success:function(data){
                console.log('success');
                location.reload();
            }
        });
        $('#confirmation-form').modal('toggle');
    });

    $("#active").click(function(){
        var css = $("#end_date-input").css("display");
        if(css === "block"){
            $("#end_date-input").css("display","none");
        }
        else{
            $("#end_date-input").css("display","block");
        }
    });

    $("#master").click(function(){
        if($("#master-div").css("display") === "none"){
            $("#master-div").css("display","block");
        }
        else{
            $("#master-div").css("display","none");
        }
    });

    $("#report").click(function(){
        if($("#report-div").css("display") === "none"){
            $("#report-div").css("display","block");
        }
        else{
            $("#report-div").css("display","none");
        }
    });

    $("#name-form").submit(function(e){
        e.preventDefault();
        $("#real_name").val($("#name_name").val());
        $("#name-form").css('display','none');
        $("#real-form").css('display','block');
    });
});