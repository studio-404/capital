var Config = {
	website:"http://capital.404.ge/",
	ajax:"http://capital.404.ge/ajax/index", 
	pleaseWait:"მოთხოვნა იგზავნება..."
};

var sign_in_try = function(){
	var ajaxFile = "/signing";
	var username = typeof $("#username").val() === "undefined" ? "" : $("#username").val();
	var password = typeof $("#password").val() === "undefined" ? "" : $("#password").val();
	var errorMsg = $(".error-msg");
	errorMsg.text(Config.pleaseWait).fadeIn();
	
	$.ajax({
		method: "POST",
		url: Config.ajax + ajaxFile,
		data: { username: username, password: password }
	}).done(function( msg ) {
		var obj = $.parseJSON(msg);
		if(obj.Error.Code==1){
			errorMsg.text(obj.Error.Text).fadeIn();
		}else{
			location.href = obj.redirect;
		}
	});
	
};

var add_page = function(){
	var ajaxFile = "/addPageForm";
	var header = "<h4>გვერდის დამატება</h4><p class=\"modal-message-box\"></p>";
	var content = "<p>გთხოვთ დაიცადოთ...</p>";
	var footer = "<a href=\"javascript:void(0)\" id=\"modalButton\" class=\"waves-effect waves-green btn-flat\">დამატება</a>";

	$("#modal1 .modal-content").html(header + content);
	$("#modal1 .modal-footer").html(footer);
	$('#modal1').openModal();

	$.ajax({
		method: "POST",
		url: Config.ajax + ajaxFile,
		data: { call: true }
	}).done(function( msg ) {
		var obj = $.parseJSON(msg);
		if(obj.Error.Code==1){
			// errorMsg.text(obj.Error.Text).fadeIn();
			var errorText = "<p>" + obj.Error.Text +"</p>";
			$("#modal1 .modal-content").html(header + errorText);
		}else{
			var form = "<p>" + obj.form +"</p>";
			$("#modal1 .modal-content").html(header + form);
			$("#choosePageType").material_select();
			$("#chooseNavType").material_select();
			$("#attachModule").material_select();
			$("#modalButton").attr({"onclick": obj.attr });
			$("#photoUploaderBox").sortable({
		    	items: ".imageItem",
				update: function( event, ui ) {  }
			});
			tiny(".tinymceTextArea");
		}
	});
};

var formPageAdd = function(){
	var ajaxFile = "/addPage";
	var chooseNavType = $("#chooseNavType").val();
	var choosePageType = $("#choosePageType").val();
	var title = $("#title").val();
	var slug = $("#slug").val();
	var cssClass = $("#cssClass").val();
	var attachModule = $("#attachModule").val();
	var redirect = $("#redirect").val();
	var pageDescription = tinymce.get('pageDescription').getContent();
	var pageText = tinymce.get('pageText').getContent();

	var photos = new Array();
	if($(".imageItem").length){
		$(".imageItem").each(function(){
			if($(".card .card-image .managerFiles", this).val()!=""){
				photos.push($(".card .card-image .managerFiles", this).val());
			}
		});
	}
	var serialPhotos = serialize(photos);

	$(".modal-message-box").html("გთხოვთ დაიცადოთ...");
	if(
		(typeof chooseNavType === "undefined" || chooseNavType=="") || 
		(typeof choosePageType === "undefined" || choosePageType=="") || 
		(typeof title === "undefined" || title=="") || 
		(typeof slug === "undefined" || slug=="") || 
		(typeof pageDescription === "undefined" || pageDescription=="") || 
		(typeof pageText === "undefined" || pageText=="")
	){
		$(".modal-message-box").html("ყველა ველი სავალდებულოა !");
	}else{
		$.ajax({
			method: "POST",
			url: Config.ajax + ajaxFile,
			data: { chooseNavType: chooseNavType, choosePageType: choosePageType, title: title, slug: slug, cssClass:cssClass, attachModule:attachModule, redirect:redirect, pageDescription: pageDescription, pageText: pageText, serialPhotos: serialPhotos }
		}).done(function( msg ) {
			var obj = $.parseJSON(msg);
			if(obj.Error.Code==1){
				$(".modal-message-box").html(obj.Error.Text);
			}else if(obj.Success.Code==1){
				$(".modal-message-box").html(obj.Success.Text);
				$("#choosePageType").val("");
				$("#title").val("");
				$("#slug").val("");
				$("#pageDescription").val("");
				$("#pageText").val("");
				scrollTop();
				location.reload();
			}else{
				$(".modal-message-box").html("E");
			}
		});
	}
};

var formPageEdit = function(idx, lang){
	var ajaxFile = "/editPage";
	var chooseNavType = $("#chooseNavType").val();
	var choosePageType = $("#choosePageType").val();
	var title = $("#title").val();
	var slug = $("#slug").val();
	var cssClass = $("#cssClass").val();
	var attachModule = $("#attachModule").val();
	var redirect = $("#redirect").val();
	var pageDescription = tinymce.get('pageDescription').getContent();
	var pageText = tinymce.get('pageText').getContent();

	var photos = new Array();
	if($(".imageItem").length){
		$(".imageItem").each(function(){
			if($(".card .card-image .managerFiles", this).val()!=""){
				photos.push($(".card .card-image .managerFiles", this).val());
			}
		});
	}
	var serialPhotos = serialize(photos);

	$(".modal-message-box").html("გთხოვთ დაიცადოთ...");
	if(
		(typeof chooseNavType === "undefined" || chooseNavType=="") || 
		(typeof choosePageType === "undefined" || choosePageType=="") || 
		(typeof title === "undefined" || title=="") || 
		(typeof slug === "undefined" || slug=="") || 
		(typeof pageDescription === "undefined" || pageDescription=="") || 
		(typeof pageText === "undefined" || pageText=="")
	){
		$(".modal-message-box").html("ყველა ველი სავალდებულოა !");
	}else{
		$.ajax({
			method: "POST",
			url: Config.ajax + ajaxFile,
			data: { idx:idx, lang: lang, chooseNavType: chooseNavType, choosePageType: choosePageType, title: title, slug: slug, cssClass:cssClass, attachModule:attachModule, redirect:redirect, pageDescription: pageDescription, pageText: pageText, serialPhotos:serialPhotos }
		}).done(function( msg ) {
			var obj = $.parseJSON(msg);
			if(obj.Error.Code==1){
				$(".modal-message-box").html(obj.Error.Text);
			}else if(obj.Success.Code==1){
				$(".modal-message-box").html(obj.Success.Text);
				scrollTop();
			}else{
				$(".modal-message-box").html("E");
			}
		});
	}
};

var changeVisibility = function(vis, idx){
	console.log(vis + " " + idx);
	var ajaxFile = "/changeVisibility";

	var header = "<h4>შეტყობინება</h4><p class=\"modal-message-box\">გთხოვთ დაიცადოთ...</p>";
	var footer = "<a href=\"javascript:void(0)\" id=\"modalButton\" class=\"waves-effect waves-green btn-flat modal-close\">დახურვა</a>";

	$("#modal1 .modal-content").html(header);
	$("#modal1 .modal-footer").html(footer);
	$('#modal1').openModal();

	if(typeof vis === "undefined" || typeof idx === "undefined"){
		$(".modal-message-box").html("E2");
	}else{
		$.ajax({
			method: "POST",
			url: Config.ajax + ajaxFile,
			data: { visibility: vis, idx: idx }
		}).done(function( msg ) {
			var obj = $.parseJSON(msg);
			if(obj.Error.Code==1){
				$(".modal-message-box").html(obj.Error.Text);
			}else if(obj.Success.Code==1){
				$(".modal-message-box").html(obj.Success.Text);
				location.reload();
			}else{
				$(".modal-message-box").html("E3");
			}
		});
	}
}

var changeModuleVisibility = function(vis, idx){
	console.log(vis + " " + idx);
	var ajaxFile = "/changeModuleVisibility";

	var header = "<h4>შეტყობინება</h4><p class=\"modal-message-box\">გთხოვთ დაიცადოთ...</p>";
	var footer = "<a href=\"javascript:void(0)\" id=\"modalButton\" class=\"waves-effect waves-green btn-flat modal-close\">დახურვა</a>";

	$("#modal1 .modal-content").html(header);
	$("#modal1 .modal-footer").html(footer);
	$('#modal1').openModal();

	if(typeof vis === "undefined" || typeof idx === "undefined"){
		$(".modal-message-box").html("E2");
	}else{
		$.ajax({
			method: "POST",
			url: Config.ajax + ajaxFile,
			data: { visibility: vis, idx: idx }
		}).done(function( msg ) {
			var obj = $.parseJSON(msg);
			if(obj.Error.Code==1){
				$(".modal-message-box").html(obj.Error.Text);
			}else if(obj.Success.Code==1){
				$(".modal-message-box").html(obj.Success.Text);
				location.reload();
			}else{
				$(".modal-message-box").html("E3");
			}
		});
	}
};

var askRemovePage = function(navType, pos, idx){
	console.log(pos + " " + idx);
	var header = "<h4>შეტყობინება</h4><p class=\"modal-message-box\">გნებავთ წაშალოთ მონაცემი ?</p>";
	var footer = "<a href=\"javascript:void(0)\" onclick=\"removePage('"+navType+"', '"+pos+"', '"+idx+"')\" class=\"waves-effect waves-green btn-flat\">დიახ</a>";
	footer += "<a href=\"javascript:void(0)\" class=\"waves-effect waves-green btn-flat modal-close\">დახურვა</a>";

	$("#modal1 .modal-content").html(header);
	$("#modal1 .modal-footer").html(footer);
	$('#modal1').openModal();
};

var askRemoveModule = function(idx){
	console.log(idx);
	var header = "<h4>შეტყობინება</h4><p class=\"modal-message-box\">გნებავთ წაშალოთ მონაცემი ?</p>";
	var footer = "<a href=\"javascript:void(0)\" onclick=\"removeModule('"+idx+"')\" class=\"waves-effect waves-green btn-flat\">დიახ</a>";
	footer += "<a href=\"javascript:void(0)\" class=\"waves-effect waves-green btn-flat modal-close\">დახურვა</a>";

	$("#modal1 .modal-content").html(header);
	$("#modal1 .modal-footer").html(footer);
	$('#modal1').openModal();
};

var removePage = function(navType, pos, idx){
	console.log(pos + " " + idx);
	var ajaxFile = "/removePage";
	if(typeof navType == "undefined" || typeof pos === "undefined" || typeof idx === "undefined"){
		$(".modal-message-box").html("E4");
	}else{
		$.ajax({
			method: "POST",
			url: Config.ajax + ajaxFile,
			data: { navType: navType, pos: pos, idx: idx }
		}).done(function( msg ) {
			var obj = $.parseJSON(msg);
			if(obj.Error.Code==1){
				$(".modal-message-box").html(obj.Error.Text);
			}else if(obj.Success.Code==1){
				$(".modal-message-box").html(obj.Success.Text);
				location.reload();
			}else{
				$(".modal-message-box").html("E5");
			}
		});
	}
};

var removeModule = function(idx){
	var ajaxFile = "/removeModule";
	if(typeof idx === "undefined"){
		$(".modal-message-box").html("E4");
	}else{
		$.ajax({
			method: "POST",
			url: Config.ajax + ajaxFile,
			data: { idx: idx }
		}).done(function( msg ) {
			var obj = $.parseJSON(msg);
			if(obj.Error.Code==1){
				$(".modal-message-box").html(obj.Error.Text);
			}else if(obj.Success.Code==1){
				$(".modal-message-box").html(obj.Success.Text);
				location.reload();
			}else{
				$(".modal-message-box").html("E5");
			}
		});
	}
};

var changePositionsOfPages = function(navType, selector){
	var ajaxFile = "/changePagePositions";
	var i = "";
	var arr = new Array(); 
	$('.'+selector+' tr').each(function(){
		i = $(this).attr("data-item");
		arr.push(i)
	});
	var serialized = serialize(arr);

	var header = "<h4>შეტყობინება</h4><p class=\"modal-message-box\">მიმდინარეობს მონაცემის განახლება...</p>";
	var footer = "<a href=\"javascript:void(0)\" class=\"waves-effect waves-green btn-flat modal-close\">დახურვა</a>";

	$("#modal1 .modal-content").html(header);
	$("#modal1 .modal-footer").html(footer);
	$('#modal1').openModal();

	$.ajax({
		method: "POST",
		url: Config.ajax + ajaxFile,
		data: { s:serialized, navType: navType }
	}).done(function( msg ) {
		var obj = $.parseJSON(msg);
		if(obj.Error.Code==1){
			$(".modal-message-box").html(obj.Error.Text);
		}else if(obj.Success.Code==1){
			$(".modal-message-box").html(obj.Success.Text);
		}else{
			$(".modal-message-box").html("E5");
		}
	});
};

var editPage = function(idx, lang){
	console.log(idx + " " + lang);
	var ajaxFile = "/editPageForm";
	var header = "<h4>გვერდის რედაქტირება</h4><p class=\"modal-message-box\"></p>";
	var content = "<p>გთხოვთ დაიცადოთ...</p>";
	var footer = "<a href=\"javascript:void(0)\" id=\"modalButton\" class=\"waves-effect waves-green btn-flat\">რედაქტირება</a>";

	$("#modal1 .modal-content").html(header + content);
	$("#modal1 .modal-footer").html(footer);
	$('#modal1').openModal();

	$.ajax({
		method: "POST",
		url: Config.ajax + ajaxFile,
		data: { idx: idx, lang:lang }
	}).done(function( msg ) {
		var obj = $.parseJSON(msg);
		if(obj.Error.Code==1){
			var errorText = "<p>" + obj.Error.Text +"</p>";
			$("#modal1 .modal-content").html(header + errorText);
		}else{
			var form = "<p>" + obj.form +"</p>";
			$("#modal1 .modal-content").html(header + form);
			$("#choosePageType").material_select();
			$("#chooseNavType").material_select();
			$("#attachModule").material_select();
			$("#modalButton").attr({"onclick": obj.attr });
			$("#photoUploaderBox").sortable({
		    	items: ".imageItem",
				update: function( event, ui ) {  }
			});
			tiny(".tinymceTextArea");
			console.log("tiny 20");
			
		}
	});
};

var add_module = function(moduleSlug){
	console.log(moduleSlug);
	var ajaxFile = "/addModuleForm";
	var header = "<h4>დამატება</h4><p class=\"modal-message-box\"></p>";
	var content = "<p>გთხოვთ დაიცადოთ...</p>";
	var footer = "<a href=\"javascript:void(0)\" id=\"modalButton\" class=\"waves-effect waves-green btn-flat\">დამატება</a>";

	$("#modal1 .modal-content").html(header + content);
	$("#modal1 .modal-footer").html(footer);
	$('#modal1').openModal();

	$.ajax({
		method: "POST",
		url: Config.ajax + ajaxFile,
		data: { moduleSlug: moduleSlug }
	}).done(function( msg ) {
		var obj = $.parseJSON(msg);
		if(obj.Error.Code==1){
			var errorText = "<p>" + obj.Error.Text +"</p>";
			$("#modal1 .modal-content").html(header + errorText);
		}else{
			var form = "<p>" + obj.form +"</p>";
			$("#modal1 .modal-content").html(header + form);
			$("#modalButton").attr({"onclick": obj.attr });
			$('.datepicker').pickadate({
				selectMonths: true, 
			});
			tiny(".tinymceTextArea");
		}
	});
};

var editModules = function(idx, lang){
	console.log(idx + " "+lang);
	var ajaxFile = "/editModules";
	var header = "<h4>რედაქტირება</h4><p class=\"modal-message-box\"></p>";
	var content = "<p>გთხოვთ დაიცადოთ...</p>";
	var footer = "<a href=\"javascript:void(0)\" id=\"modalButton\" class=\"waves-effect waves-green btn-flat\">რედაქტირება</a>";

	$("#modal1 .modal-content").html(header + content);
	$("#modal1 .modal-footer").html(footer);
	$('#modal1').openModal();

	$.ajax({
		method: "POST",
		url: Config.ajax + ajaxFile,
		data: { idx: idx, lang:lang }
	}).done(function( msg ) {
		var obj = $.parseJSON(msg);
		if(obj.Error.Code==1){
			var errorText = "<p>" + obj.Error.Text +"</p>";
			$("#modal1 .modal-content").html(header + errorText);
		}else{
			var form = "<p>" + obj.form +"</p>";
			$("#modal1 .modal-content").html(header + form);
			$("#modalButton").attr({"onclick": obj.attr });
			tiny(".tinymceTextArea");			
		}
	});
};

var formModuleEdit = function(idx, lang){
	var ajaxFile = "/editFormModules";
	var date = $("#date").val();
	var title = $("#title").val();
	var pageText = tinymce.get('pageText').getContent();
	var link = (typeof $("#link").val() === "undefined" || $("#link").val()=="") ? $("#link").val() : "empty";

	$(".modal-message-box").html("გთხოვთ დაიცადოთ...");
	if(
		(typeof date === "undefined" || date=="") || 
		(typeof title === "undefined" || title=="") || 
		(typeof pageText === "undefined" || pageText=="")
	){
		$(".modal-message-box").html("ყველა ველი სავალდებულოა !");
	}else{
		$.ajax({
			method: "POST",
			url: Config.ajax + ajaxFile,
			data: { idx:idx, lang: lang, date: date, title: title, pageText: pageText, link:link }
		}).done(function( msg ) {
			var obj = $.parseJSON(msg);
			if(obj.Error.Code==1){
				$(".modal-message-box").html(obj.Error.Text);
			}else if(obj.Success.Code==1){
				$(".modal-message-box").html(obj.Success.Text);
				scrollTop();
			}else{
				$(".modal-message-box").html("E");
			}
		});
	}
};

var formModuleAdd = function(moduleSlug){
	var date = $("#date").val();
	var title = $("#title").val();
	var pageText = tinymce.get('pageText').getContent();
	var link = (typeof $("#link").val() === "undefined" || $("#link").val()=="") ? $("#link").val() : "empty";

	var ajaxFile = "/addModule";
	if(typeof moduleSlug == "undefined" || typeof date == "undefined" || typeof title === "undefined" || typeof pageText === "undefined"){
		$(".modal-message-box").html("E4");
	}else{
		$.ajax({
			method: "POST",
			url: Config.ajax + ajaxFile,
			data: { moduleSlug: moduleSlug, date: date, title: title, pageText: pageText, link:link }
		}).done(function( msg ) {
			var obj = $.parseJSON(msg);
			if(obj.Error.Code==1){
				$(".modal-message-box").html(obj.Error.Text);
			}else if(obj.Success.Code==1){
				$(".modal-message-box").html(obj.Success.Text);
				location.reload();
			}else{
				$(".modal-message-box").html("E5");
			}
			scrollTop();
		});
	}
};

 
var searchStatement = function(pid){
	var ajaxFile = "/searchStatement";
	var header = "<h4>განცხადება</h4><p class=\"modal-message-box\"></p>";
	var content = "<p>გთხოვთ დაიცადოთ...</p>";
	var footer = "<a href=\"javascript:void(0)\" class=\"waves-effect waves-green btn-flat modal-close\">დახურვა</a>";

	$("#modal1 .modal-content").html(header + content);
	$("#modal1 .modal-footer").html(footer);
	$('#modal1').openModal();

	$.ajax({
		method: "POST",
		url: Config.ajax + ajaxFile,
		data: { pid: pid }
	}).done(function( msg ) {
		var obj = $.parseJSON(msg);
		if(obj.Error.Code==1){
			var errorText = "<p>" + obj.Error.Text +"</p>";
			$("#modal1 .modal-content").html(header + errorText);
		}else{
			var table = "<p>" + obj.table +"</p>";
			$("#modal1 .modal-content").html(header + table);
		}
	});
};

var askRemoveStatement = function(id){
	var header = "<h4>შეტყობინება</h4><p class=\"modal-message-box\">გნებავთ წაშალოთ მონაცემი ?</p>";
	var footer = "<a href=\"javascript:void(0)\" onclick=\"removeStatement('"+id+"')\" class=\"waves-effect waves-green btn-flat\">დიახ</a>";
	footer += "<a href=\"javascript:void(0)\" class=\"waves-effect waves-green btn-flat modal-close\">დახურვა</a>";

	$("#modal1 .modal-content").html(header);
	$("#modal1 .modal-footer").html(footer);
	$('#modal1').openModal();	
}; 

var removeStatement = function(id){
	var ajaxFile = "/removeStatement";
	if(typeof id == "undefined"){
		$(".modal-message-box").html("E4");
	}else{
		$.ajax({
			method: "POST",
			url: Config.ajax + ajaxFile,
			data: { id: id }
		}).done(function( msg ) {
			var obj = $.parseJSON(msg);
			if(obj.Error.Code==1){
				$(".modal-message-box").html(obj.Error.Text);
			}else if(obj.Success.Code==1){
				$(".modal-message-box").html(obj.Success.Text);
				location.reload();
			}else{
				$(".modal-message-box").html("E5");
			}
		});
	}
};

var openFileManager = function(photosBox, id){
	var overlay = document.createElement("div");
	overlay.id = "overlay"+id;
	
	var boxHeader = document.createElement("p");
	boxHeader.id = "boxHeader"+id;

	var closeBox = document.createElement("p");
	closeBox.id = "closeBox"+id;

	boxHeader.append(closeBox);

	var t = document.createTextNode("აირჩიეთ ფაილი");
	boxHeader.appendChild(t);

	var box = document.createElement("div");
	box.id = "box"+id;

	var fileManager = document.createElement("div");
	fileManager.id = "fileManager"+id;

	box.append(boxHeader);
	box.append(fileManager);


	$("body").append(overlay).append(box);
	$("body").css("overflow-y","hidden"); 

	$("#overlay"+id).css({
		"background-color":"#000000",
		"opacity":"0.5",
		"position":"fixed",
		"z-index":"1100",
		"top":"0px",
		"left":"0px",
		"width":"100%",
		"height":"100%"
	});

	$("#box"+id).css({
		"background-color":"#ffffff",
		"position":"fixed",
		"z-index":"1200",
		"top":"50px",
		"left":"calc(50% - 500px)",
		"width":"1000px",
		"height":"450px"
	});

	$("#boxHeader"+id).css({
		"width":"calc(100% - 20px)",
		"height":"20px",
		"font-size":"18px",
		"line-height":"20px", 
		"margin":"10px",
		"float":"left",
		"position":"relative"
	});

	$("#closeBox"+id).css({
		"width":"15px", 
		"height":"15px", 
		"position":"absolute", 
		"right":"0px", 
		"top":"4px", 
		"background-image":"url('/public/img/cancel.png')",
		"background-size":"15px 15px",
		"background-repeat":"no-repeat", 
		"background-position":"center center",
		"cursor":"pointer" 
	});
	$("#closeBox"+id).attr("onclick", "closeFileManager('"+id+"')");

	$("#fileManager"+id).elfinder({
		url : '/public/elfinder/php/connector.minimal.php', 
		docked: false,
        dialog: { width: 400, modal: true },
        closeOnEditorCallback: true, 
		getFileCallback: function(url) {
            $("#"+id+" .card .card-image .activator").attr("src",Config.website+"image/loadimage?f="+Config.website+"public/"+url.path+"&w=215&h=173");
            $("#"+id+" .card .card-image .managerFiles").val("/public/"+url.path);
            photoUploaderBox(photosBox);
            closeFileManager(id); 
        }
	});
	$("#fileManager"+id).css({
		"width":"calc(100% - 20px)",
		"margin":"0px 10px",
		"float":"left"
	});
};

var closeFileManager = function(id){
	$("#box"+id).remove();
    $("#overlay"+id).remove();
};

var photoUploaderBox = function(photosBox){
	console.log(photosBox+" in");
	var count = $("#"+photosBox+" .imageItem").length + 1;
	var out = "<div class=\"col s4 imageItem noImageSelected\" id=\"img"+count+"\">";
	out += "<div class=\"card\">";
	out += "<div class=\"card-image waves-effect waves-block waves-light\">";
	out += "<input type=\"hidden\" name=\"managerFiles[]\" class=\"managerFiles\" value=\"\" />";
	out += "<img class=\"activator\" src=\"/public/img/noimage.png\" />";
	out += "</div>";
	out += "<div class=\"card-content\">";
	out += "<p>";
	out += "<a href=\"javascript:void(0)\" onclick=\"openFileManager('photoUploaderBox', 'img"+count+"')\" class=\"large material-icons\">mode_edit</a>";
	out += "<a href=\"javascript:void(0)\" onclick=\"removePhotoItem('img"+count+"')\" class=\"large material-icons\">delete</a>";
	out += "</p>";
	out += "</div>";
	out += "</div>";
	out += "</div>";
	$("#" + photosBox).append(out);
};

var removePhotoItem = function(imageBoxId){
	$("#"+imageBoxId).fadeOut().remove();
}

$(document).ready(function(){
    $('.collapsible').collapsible({
      accordion : false 
    });
    $('.tooltipped').tooltip({delay: 50});
    $('.sortablePagePositionChange').sortable({
    	items: ".level-0",
		update: function( event, ui ) { changePositionsOfPages(0, 'sortablePagePositionChange'); }
	});
	$('.sortablePagePositionChange').disableSelection();

	$('.sortablePagePositionChange2').sortable({
    	items: ".level2-0",
		update: function( event, ui ) { changePositionsOfPages(1, 'sortablePagePositionChange2'); }
	});
	$('.sortablePagePositionChange2').disableSelection();

	//sortablePagePositionChange2
 });

/* Additional functions */
var tiny = function(selector){
	tinymce.remove();
	tinymce.init({
		selector: selector, 
		theme: "modern",
	    plugins: [
	        "autolink lists link image hr pagebreak",
	        "wordcount visualblocks",
	        "insertdatetime save table contextmenu directionality",
	        "paste textcolor colorpicker textpattern",
	        "code", 
	        "textcolor"
	    ],
	    toolbar1: "insertfile undo redo | styleselect | bold italic | link image | numlist | bullist | table | code | forecolor | backcolor",
	    image_advtab: true, 
	    extended_valid_elements : "iframe[src|width|height|name|align]", 
	    relative_urls : 0, 
		remove_script_host : 0, 
		body_class: 'myTineMce', 
		file_browser_callback : elFinderBrowser
	});
};

var elFinderBrowser = function(field_name, url, type, win) {
  tinymce.activeEditor.windowManager.open({
    file: Config.website+'public/elfinder/elfinder.html',// use an absolute path!
    title: 'elFinder 2.0',
    width: 900,  
    height: 450,
    resizable: 'yes'
  }, {
    setUrl: function (url) {
      win.document.getElementById(field_name).value = url;
    }
  });
  return false;
};

var serialize = function(mixed_value) {
	var val, key, okey,
	ktype = '',
	vals = '',
	count = 0,
	_utf8Size = function(str) {
		var size = 0,
		i = 0,
		l = str.length,
		code = '';
		for (i = 0; i < l; i++) {
			code = str.charCodeAt(i);
			if (code < 0x0080) {
				size += 1;
			} else if (code < 0x0800) {
				size += 2;
			} else {
			size += 3;
			}
		}
		return size;
	};
	_getType = function(inp) {
		var match, key, cons, types, type = typeof inp;

		if (type === 'object' && !inp) {
			return 'null';
		}
		if (type === 'object') {
			if (!inp.constructor) {
				return 'object';
			}
			cons = inp.constructor.toString();
			match = cons.match(/(\w+)\(/);
			if (match) {
				cons = match[1].toLowerCase();
			}
			types = ['boolean', 'number', 'string', 'array'];
			for (key in types) {
				if (cons == types[key]) {
					type = types[key];
					break;
				}
			}
		}
		return type;
	};
	type = _getType(mixed_value);

	switch (type) {
		case 'function':
			val = '';
			break;
		case 'boolean':
			val = 'b:' + (mixed_value ? '1' : '0');
			break;
		case 'number':
			val = (Math.round(mixed_value) == mixed_value ? 'i' : 'd') + ':' + mixed_value;
			break;
		case 'string':
			val = 's:' + _utf8Size(mixed_value) + ':"' + mixed_value + '"';
			break;
		case 'array':
			case 'object':
				val = 'a';

				for (key in mixed_value) {
					if (mixed_value.hasOwnProperty(key)) {
						ktype = _getType(mixed_value[key]);
						if (ktype === 'function') {
							continue;
						}
						okey = (key.match(/^[0-9]+$/) ? parseInt(key, 10) : key);
						vals += this.serialize(okey) + this.serialize(mixed_value[key]);
						count++;
					}
				}
				val += ':' + count + ':{' + vals + '}';
				break;
		case 'undefined':
			default:
				val = 'N';
				break;
	}

	if (type !== 'object' && type !== 'array') {
		val += ';';
	}
	return val;
};

var scrollTop = function(){
	var body = $("html, body");
	body.stop().animate({scrollTop:0}, '500', 'swing', function() { });
};