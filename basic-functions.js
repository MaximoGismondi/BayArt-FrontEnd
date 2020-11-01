/*Rotar Flecha*/
var arrowState = false;
function changeArrow() {
    arrowState = !arrowState;
    if(arrowState == true){
        $('#img-arrow').css({transform: "rotate(90deg)"});
        $('#div-filter').css({visibility: "visible", opacity: "1"});
    }
    else{
        $('#img-arrow').css({transform: "rotate(0deg)"});
        $('#div-filter').css({opacity: "0"});
        setTimeout( function(){
            $('#div-filter').css({visibility: "hidden"});
        },100);
    }
}

$("#button-arrow").click(changeArrow);


/*Header scroll*/

var firstUbication = window.pageYOffset;
window.onscroll = function(){
    if(document.getElementById("nav-subtitle") != null){
    var actualUbication = window.pageYOffset;
    if (firstUbication < actualUbication){
        document.getElementById("nav-subtitle").style.opacity = "0";
        document.getElementById("nav-subtitle").style.marginTop = "-200px";
        if(arrowState == true){
            changeArrow();
        }
    } 
    else {
        document.getElementById("nav-subtitle").style.opacity = "1";
        if(window.screen.width < 546){
            document.getElementById("nav-subtitle").style.marginTop = "60px";
        }
        else{
            document.getElementById("nav-subtitle").style.marginTop = "20px";
        }
        
    }
    firstUbication = actualUbication;}
}

/*Bloquear filtro upload*/

function displayCheckbox(opacityCheckbox, status){
    var indexLabel = 1;
    for (let i = 1; i <= 2; i++){
        $("#div-column" + i).find('input').each(function (index){
            if(opacityCheckbox==0.3 && !$(this).prop('checked') || opacityCheckbox==1){
                $(this).css("opacity",opacityCheckbox);
                $(this).css("pointer-events",status);
                $("#label" + indexLabel).css("opacity",opacityCheckbox);
            }
            indexLabel++;
        });
        
    }
}

/*Estirar Perfil*/
var profileState = true;
var changing = false;
var widthProfileBar = $("#div-profile").width();
var displayName = $("#div-name-type").css("display");
function changeProfileWidth(){
    if(!changing){
        profileState = !profileState;
    if(profileState){
        changing = true;
        $("#div-secondary-buttons").css({opacity: "0"});
        $('#div-profile').css({width: widthProfileBar});
        setTimeout( function(){
            $("#div-secondary-buttons").css({visibility: "hidden"});
        },100);
    
        setTimeout( function(){
            console.log(widthProfileBar);
            $('#div-bpoints').css({display: "inline-block"});
            $('#div-name-type').css({display: displayName});
            $('#div-name-type').css({opacity: "1"});
            $('#label-bpoints').css({opacity: "1"});
            $('#img-bpoints').css({opacity: "1"});
            changing=false;
        },850);
        
    }
    else{
        changing = true;
        $('#img-bpoints').css({opacity: "0"});
        $('#label-bpoints').css({opacity: "0"});
        $('#div-name-type').css({opacity: "0"});
        setTimeout( function(){
            $('#div-bpoints').css({display: "none"});
            $('#div-name-type').css({display: "none"});
            $('#div-profile').css({width: "50px"});
        },300);
        setTimeout(function(){
            $("#div-secondary-buttons").css({visibility: "visible"});
            $("#div-secondary-buttons").css({opacity: "1"});
        },800)
        setTimeout( function(){
            changing=false;
        },1050);
    }
    }
}

$("#div-profile-picture").click(changeProfileWidth);

/*Animacion botones secundarios*/

function secondaryButtonsHover(buttonName, shown){
    if(shown){
        $("#div-secondary-button-"+buttonName+"-text").css("color", "#00a797");
        $("#img-secondary-button-"+buttonName+"-white").css("opacity",0);
        $("#img-secondary-button-"+buttonName+"-green").css("opacity",1);
        if(buttonName == "settings"){
            $("#img-secondary-button-settings-green").css("transform","rotate(90deg)"); 
            $("#img-secondary-button-settings-white").css("transform","rotate(90deg)");     
        }
        else if(buttonName == "profile"){
            $("#img-secondary-button-profile-green").css("transform","translateY(-6px)"); 
            $("#img-secondary-button-profile-white").css("transform","translateY(-6px)");     
        }
        else{
            $("#img-secondary-button-library-green").css("transform","translateY(-6px)");
            $("#img-secondary-button-library-white").css("transform","translateY(-6px)");  
        }
    }
    else{
        $("#div-secondary-button-"+buttonName+"-text").css("color", "white");
        $("#img-secondary-button-"+buttonName+"-white").css("opacity",1);
        $("#img-secondary-button-"+buttonName+"-green").css("opacity",0);
        if(buttonName == "settings"){    
            $("#img-secondary-button-settings-green").css("transform","rotate(0deg)");  
            $("#img-secondary-button-settings-white").css("transform","rotate(0deg)");      
        }
        else if(buttonName == "profile"){
            $("#img-secondary-button-profile-green").css("transform","translateY(0)"); 
            $("#img-secondary-button-profile-white").css("transform","translateY(0)");
        }
        else{
            $("#img-secondary-button-library-green").css("transform","translateY(0)"); 
            $("#img-secondary-button-library-white").css("transform","translateY(0)");
        }
    }        
}

$("#a-secondary-button-profile").mouseenter(function(){secondaryButtonsHover("profile",true)});
$("#a-secondary-button-profile").mouseleave(function(){secondaryButtonsHover("profile",false)});

$("#a-secondary-button-library").mouseenter(function(){secondaryButtonsHover("library",true)});
$("#a-secondary-button-library").mouseleave(function(){secondaryButtonsHover("library",false)});
		
$("#a-secondary-button-settings").mouseenter(function(){secondaryButtonsHover("settings",true)});
$("#a-secondary-button-settings").mouseleave(function(){secondaryButtonsHover("settings",false)});


/*Cambiar texto label checkBox*/
function checkBoxState(idCheck, color1, color2){
    var idLabel = "label" + idCheck.slice(14);
    if($('#'+idCheck).prop('checked')){
        $("#"+idLabel).css( "color" , color1);
    }
    else{
        $("#"+idLabel).css( "color" , color2);
    }
};

$(".input-checkbox").click(function (){
    var idCheckBox = $(this).attr("id");
    checkBoxState(idCheckBox, "white", "#7c7c7c");
}); 

$("#input-checkBox-keep-me").click(function (){
    var idCheckBox = $(this).attr("id");
    checkBoxState(idCheckBox, "white", "#7c7c7c");
}); 


/*Ocultar/Mostrar contraseña*/
var visibility = false;
function showPassword(){
    if(!visibility){
        document.getElementById("input-password").type = "text";
        document.getElementById("img-eye").src = "../icons/closed-eye.png"; 
    }
    else{
        document.getElementById("input-password").type = "password";
        document.getElementById("img-eye").src = "../icons/open-eye.png"; 
    }
    visibility = !visibility;
}

$("#img-eye").click(showPassword);

/*Setear alto y ancho de imagen*/

function setWidthHeight(idImage, idDiv, maxWidth, maxHeight){

    var height = $("#"+idImage).height();
    var width = $("#"+idImage).width();

    var relationHeightMaxHeight = height/maxHeight;
    var relationWidhtMaxWidth = width/maxWidth;

    if(relationHeightMaxHeight > relationWidhtMaxWidth){
        $("#"+idImage).css('height',maxHeight);
        $("#"+idDiv).css('height',(maxHeight+40));
        $("#"+idImage).css('width',"auto");
        $("#"+idDiv).css('width',((width/relationHeightMaxHeight)+40));
    }
    else{
        $("#"+idImage).css('width',maxWidth);
        $("#"+idDiv).css('width',(maxWidth+40));
        $("#"+idImage).css('height',"auto");
        $("#"+idDiv).css('height',((height/relationWidhtMaxWidth)+40));
    }

}

/*------------------------------------------------------------------------*/
function getWidth(element){
    return parseFloat((window.getComputedStyle(element).width).slice(0,-2));
}

/*Ordenar fotos menu principal*/
function orderImages(id, minHeight, margin){

    var numImages = 0;
    var actualImage = 0;
    var totalHeight = margin;

    //Agregar id a las imagenes y obtener la cantidad

    $("#"+id).find('img').each(function (index){

        $(this).attr('id','img-main-'+index);
        numImages++;

    }); 

    //Insertar x imagenes en un sub div y ajustarlas

    for (var actualRow = 0; actualImage < numImages; actualRow++) {

        var changeRow = false;
        var rowWidth = 0;
        var numImagesRow = 0;

        var newRow = document.createElement('div');
        newRow.id = "image-row-"+actualRow;
        newRow.style.marginTop = margin;

        //Agregar Imagenes a fila

        while(!changeRow  && actualImage < numImages){

            var idWidth = getWidth(document.getElementById(id)) - margin;
            var insertImage = document.getElementById("img-main-"+actualImage);

            insertImage.style.height = minHeight;
            insertImage.style.width = "auto";
            insertImage.style.borderRadius = "10px";

            if (getWidth(insertImage) + margin > idWidth) {
                insertImage.style.width = idWidth-margin;
                insertImage.style.height = "auto";
            }

            //Agrega Imagenes
            
            if((idWidth - rowWidth ) >= getWidth(insertImage) + margin){       

                rowWidth += getWidth(insertImage);

                newDivImage = document.createElement("div");
                newDivImage.id = "div-img-main-"+actualImage;
                newDivImage.className = "div-img-main";
                newDivImage.style.display = "inline-block";
                newDivImage.style.marginLeft = margin;

                newDivGradient = document.createElement("div");
                newDivGradient.id = "div-gradient-main-"+actualImage;
                newDivGradient.className = "div-gradient-main";

                newDivImgProfile = document.createElement("div");
                newDivImgProfile.id = "div-img-profile-"+actualImage;
                newDivImgProfile.className = "div-img-profile";

                newH3ImgName= document.createElement("h3");
                newH3ImgName.innerHTML = "Title";
                newH3ImgName.id = "h3-img-name-"+actualImage;
                newH3ImgName.className = "h3-img-name";

                newH6ImgName= document.createElement("h6");
                newH6ImgName.innerHTML = "Artist name";
                newH6ImgName.id = "h6-img-name-"+actualImage;
                newH6ImgName.className = "h6-img-name";

                newDivGradient.appendChild(newH6ImgName);

                newDivGradient.appendChild(newH3ImgName);

                newDivGradient.appendChild(newDivImgProfile);

                newDivImage.appendChild(newDivGradient);

                newDivImage.appendChild(insertImage);

                newRow.appendChild(newDivImage);
                actualImage++;
                numImagesRow++;
            }

            //Cambiar de fila

            else{
                changeRow = true;
            }

        }

        //Inserta fila al id enviado

        document.getElementById(id).appendChild(newRow);

        //Ajusta el width de las fotos para un encastre perfecto

        var multiplierToGrow = (idWidth - numImagesRow*margin) / rowWidth;


        $("#image-row-"+actualRow).find('img').each(function (){

            if ($(this).height()*multiplierToGrow <= minHeight*2) {
                $(this).css("width", $(this).width()*multiplierToGrow);
                $(this).css("height", $(this).height()*multiplierToGrow);
            }

            else {
                $(this).css("height",minHeight*2);
                $(this).css("width","auto");
            }
            var idDivImgMain = $(this).attr("id");
            idDivImgMain = idDivImgMain.slice(9);
            document.getElementById("div-img-main-"+idDivImgMain).style.height = $(this).height();
            document.getElementById("div-img-main-"+idDivImgMain).style.width  = $(this).width();
            document.getElementById("div-gradient-main-"+idDivImgMain).style.height = $(this).height();
            document.getElementById("div-gradient-main-"+idDivImgMain).style.width  = $(this).width();
        });
        

        totalHeight += ($("#image-row-"+actualRow).height() + margin);
    }


    $("#"+id).css("height",totalHeight);
}

//Contador de caracteres Descripcion
function charcountupdate(str) {
	var lng = str.length;
	document.getElementById("h4-character-counter").innerHTML = lng + ' out of 1000 characters';
}

//Borrar imagen Upload Image
function deleteImage(){
    $("#img-uploaded").css("display","none");
    $("#div-drag-drop").css("display","block");
    $("#div-cancel-image").css("display","none");
    $("#div-image-description").css("height", "500px");
    $("#div-image").css("width", "calc(50% - 10px)");
    $("#div-image").css("height", "100%");
    $("#div-description").css("width", "calc(50% - 10px)");
    $("#div-description").css("height", "100%");
    $("#input-image").val(null);
}

//tema claro y oscuro

function changeTheme(checkbox){
    if (checkbox.checked){
        //cambios generales
        $("body").css( "background" , "#d3d3d3");
        $("header").css( "background" , "#d3d3d3");
        $(".options").css( "background" , "#a7a7a7");
        $("#div-profile").css( "background" , "#a7a7a7");
        $("#nav-subtitle").css( "background" , "#a7a7a7");
        $("#div-filter").css( "background" , "#d3d3d3");
        $(".input-checkbox").css( "background" , "#a7a7a7");
        $("main").css( "background" , "#a7a7a7");
        //pops ups
        $("#div-pop-up").css( "background" , "#d3d3d3");
        $("#input-price").css( "background" , "#a7a7a7");
        //individual image
        $("#div-image").css( "background" , "#d3d3d3");
        $("#div-title-description").css( "background" , "#d3d3d3");
        $("#div-artist").css( "background" , "#d3d3d3");
        $("#div-title-comments").css( "background" , "#d3d3d3");
        //own-profile
        $("#div-container-buttons").css( "background" , "#a7a7a7");
        $("#button-uploaded-images").css( "background" , "#d3d3d3");
        $("#button-library-images").css( "background" , "#d3d3d3");
        //search
        $("#div-filter").css( "background" , "#d3d3d3");
        //settings
        $(".things-settings").css( "background" , "#d3d3d3");
        //store
        $(".div-image").css( "background" , "#e6e6e6");
        $(".div-image").css( "background" , "#d2d2d2");
        $(".div-cancel-image").css( "background" , "#d2d2d2");
        //upload image
        $("#div-title").css( "background" , "#d3d3d3");
        $("#div-image").css( "background" , "#d3d3d3");
        $(".div-cancel-image").css( "background" , "#d3d3d3");
        $("#div-description").css( "background" , "#d3d3d3");
        $("#div-description-text").css( "background" , "#c3c3c3");
        $("#div-tags").css( "background" , "#d3d3d3");
        $("#div-price").css( "background" , "#d3d3d3");
        $("#input-checkBox-price").css( "background" , "#a7a7a7");
        $("#input-price").css( "background" , "#a7a7a7");
    }

    else{
        //cambios generales
        $("body").css( "background" , "#242424");
        $("header").css( "background" , "#242424");
        $(".options").css( "background" , "#3d3d3d");
        $("#div-profile").css( "background" , "#3d3d3d");
        $("#nav-subtitle").css( "background" , "#3d3d3d");
        $("#div-filter").css( "background" , "#242424");
        $(".input-checkbox").css( "background" , "#3d3d3d");
        $("main").css( "background" , "#3d3d3d");
        //pops ups
        $("#div-pop-up").css( "background" , "#242424");
        $("#input-price").css( "background" , "#3d3d3d");
        //individual image
        $("#div-image").css( "background" , "#242424");
        $("#div-title-description").css( "background" , "#242424");
        $("#div-artist").css( "background" , "#242424");
        $("#div-title-comments").css( "background" , "#242424");
        //own-profile
        $("#div-container-buttons").css( "background" , "#3d3d3d");
        $("#button-uploaded-images").css( "background" , "#242424");
        $("#button-library-images").css( "background" , "#242424");
        //search
        $("#div-filter").css( "background" , "#242424");
        //settings
        $(".things-settings").css( "background" , "#242424");
        //store
        $(".div-image").css( "background" , "#242424");
        $(".div-image").css( "background" , "#121212");
        $(".div-cancel-image").css( "background" , "#2d2d2d");
        //upload image
        $("#div-title").css( "background" , "#242424");
        $("#div-image").css( "background" , "#242424");
        $(".div-cancel-image").css( "background" , "#242424");
        $("#div-description").css( "background" , "#242424");
        $("#div-description-text").css( "background" , "#3c3c3c");
        $("#div-tags").css( "background" , "#242424");
        $("#div-price").css( "background" , "#242424");
        $("#input-checkBox-price").css( "background" , "#3d3d3d");
        $("#input-price").css( "background" , "#3d3d3d");
    }
}