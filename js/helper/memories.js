window.Memories = function() {
	this.collection = $(".bookmark");
	this.request = function(method, callback) {
		$.ajax({
			url: "core.php",
			data: method,
			success: callback
		});
	}
}

window.Memories.prototype = {

	setHandlers: function() {
	
		var instance = this;
		this.collection.find(".remove").live("click", function() {
			var bookmark = this.parentNode;
			if(confirm(("Точно удалить?"))) {
				instance.request("method=user/remove_memory&id=" + bookmark.id, function(data) {
					bookmark.parentNode.removeChild(bookmark);
				});
			}
		});
		this.collection.find(".edit").live("click", function() {
			var $title = $(".title", this.parentNode),
				$bookmark = $(".link a", this.parentNode);
			var title = prompt("Введите новое название:", $title.text()),
				bookmark = prompt("Введите новую ссылку:", $bookmark.text());
			User.prototype.editMemory("title=" + title + "&bookmark=" + bookmark, function(data) {
				if(data.result) {
					$title.text(title);
					$bookmark.text(bookmark).href(bookmark);
				} else {
					alert(data.message);
				}
			});
		});
		
	},
	
	/* @public static */
	createMemory: function(title, bookmark) {
		var newBoolmark = $(".bookmark").last().clone().appendTo("#bookmarks").show();
		newBoolmark.find(".title").html(title);
		newBoolmark.find(".link a").html(bookmark).attr("href", bookmark);
		var $noBookmarks = $("#no_bookmarks");
		if($noBookmarks.is(":visible")) $noBookmarks.hide();
	}
	
}