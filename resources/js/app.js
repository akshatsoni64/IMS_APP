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

    $("#toggle-nav-div").click(function(){
        var css = $("#nav-div").css("display");
        if(css == "none"){
            $("#nav-div").css("display","block");
            $("#toggle-nav-div").html("<i class='font-weight-bold fa fa-angle-left'></i>");
        }
        else{
            $("#nav-div").css("display","none");
            $("#toggle-nav-div").html("<i class='font-weight-bold fa fa-angle-right'></i>");
        }
    });
    
    $("#toggle-add-form").click(function(){
        var css = $("#"+document.URL.split("/")[3]+"-form-div").css("display");
        var title = $("#toggle-add-form").attr("title").split(" ");
        if(css === "none"){
            $("#"+document.URL.split("/")[3]+"-form-div").css("display","block");
            $("#load-stock-div").css("display","none");
            $("#date-form-div").css("display","none");
            $("#toggle-add-form").html("<i class='fa fa-times text-danger'></i>");
            $("#toggle-add-form").attr("title","Close "+title[1]+" Form");
        }
        else{
            $("#"+document.URL.split("/")[3]+"-form-div").css("display","none");
            $("#load-stock-div").css("display","block");
            $("#date-form-div").css("display","block");
            $("#toggle-add-form").html("<i class='fa fa-plus'></i>");
            $("#toggle-add-form").attr("title","Add "+title[1]);
        }
        $("#form-div input:visible, #form-div select:visible").first().focus()
    });
    
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:url,
            type:'DELETE',
            success:function(data){
                if(data == "Failed"){
                    alert("Transactions are there, Can't delete!")
                }
                else{
                    location.reload();
                }
            }
        });
        $('#confirmation-form').modal('toggle');
    });

    $("#active").click(function(){
        var active = $("#active")[0].checked;
        $("#end_date").attr("required",!active);
        $("#warn-div").css("display",(!active) ? "block" : "none");
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

    $("#stock-customer").change(function(){
        var val = $(this).val();
        var options = "<option selected disabled value=''>Product Name</option>";
        $.ajax({
            url:'/stock-prod/'+val,
            type:'GET',
            success:function(data){
                data = $.parseJSON(data);
                $.each(data, function(index, value){
                    options += "<option value="+value.id+">"+value.name+"</option>";
                });
                $("#stock-products").html(options);
            }
        });
    });

    $("#toggle-reportform").click(function(){
        var css = $("#report-form").css("display");
        if(css == "none"){
            $("#report-form").css("display","block");
        }
        else{
            $("#report-form").css("display","none");
        }
    });
/*
    $("#submit-customer").click(function(){
        
        $("#submit-customer").attr("disabled",true);
        var cname = $("#c_name").val();
        var c_mobile = $("#c_mobile").val();
        var cust_id = $("#cust_id").val();

        $.ajax({
            url:"/v_cname",
            type:"GET",
            data:{'cname': cname, "cust_id": cust_id, 'c_mobile': c_mobile},
            success:function(data){
                if(data == "Success"){
                    $("#customer-form-div").submit();
                }
                else{
                    alert("Duplicate Entry for Customer!");
                }
            }
        });
    });
*/
    $("#customer-form-div").submit(function(e){
        e.preventDefault();
        
        // $("#submit-customer").attr("disabled",true);
        var cname = $("#c_name").val();
        var c_mobile = $("#c_mobile").val();
        var cust_id = $("#cust_id").val();        

        $.ajax({
            context: this,
            url:"/v_cname",
            type:"GET",
            data:{'cname': cname, "cust_id": cust_id, 'c_mobile': c_mobile},
            success:function(data){
                if(data != "Success"){
                    alert(data+": Duplicate Entry for Customer!");
                }
                else{
                    this.submit();
                }
            }
        });
    });

    $("#product-form-div").submit(function(e){
        e.preventDefault();

        var pname = $("#p_name").val();
        var prod_id = $("#prod_id").val();

        $.ajax({
            context:this,
            url:"/v_pname",
            type:"GET",
            data:{'pname': pname, "prod_id": prod_id},
            success:function(data){
                console.log(data);
                if(data != "Success"){
                    alert(data+": Duplicate Entry for Product!");
                }
                else{
                    this.submit();
                }
            }
        });
    });
/*
    $("#submit-product").click(function(){

        var pname = $("#p_name").val();
        var prod_id = $("#prod_id").val();

        $.ajax({
            url:"/v_pname",
            type:"GET",
            data:{'pname': pname, "prod_id": prod_id},
            success:function(data){
                console.log(data);
                if(data == "Success"){
                    $("#product-form-div").submit();
                }
                else{
                    alert("Duplicate Product Name!");
                }
            }
        });
    });
 */   
    $("#transaction-form-div").submit(function(e){
        var is = Number($("#t_issue").val());
        var re = Number($("#t_receive").val());
        var sum = (is+re)
        if(sum <= 0){
            alert("Issue & Receive both can't be 0!");
            e.preventDefault();
        }
    });
    
});
