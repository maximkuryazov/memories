(function() {

	window.User = function(id) {
		this.id = id;
	}
	
	window.User.prototype = {
		
		getAllMemories: function() {
			var result = {};
			$.ajax({
				url: "core.php",
				type: "POST",
				data: "method=user/get_all_memories",
				async: false,
				success: function(data) {
					result = { memories: data };
				}
			});
			return result;
		},
		
		createMemory: function(serialize) {
			$.ajax({
				url: "core.php",
				type: "POST",
				data: "method=user/add_memory&" + serialize,
				success: function(data) {
					var $message = $("#new_bookmark_message");
					$message.show().html(data.message);
					if(data.result) {
						var form = document.forms.new_memory;
						Memories.prototype.createMemory(form.title.value, form.bookmark.value);
						form.title.value = form.bookmark.value = "";
						setTimeout(function() { 
							$message.fadeOut();
						}, 1000);
					}
				}
			});
		},
		
		/* @public static */
		editMemory: function(serialize, callback) {
			$.ajax({
				url: "core.php",
				type: "POST",
				data: "method=memory/edit_memory&" + serialize,
				success: callback
			});
		},
		
		logout: function() {
			$.get("core.php", "method=user/logout", function(response) {
				if(response.result) {
					location.reload();
				}
			});
		}
		
	}
	
})();