require(["helper/jquery.min"], function() {

	require(["helper/jquery.form"], function() {
		
		/* authorization */
		
		$("#authorization").ajaxForm(function(data) {
			if(!data.result) {
				$("#autho-error-message").html(data.message);
			} else {
				require(["helper/ejs", "helper/memories", "helper/user"], function() {
				
					// account
				
					var currentUser = new User(data.userID);
					var template = currentUser.getAllMemories();
					var html = new EJS({ url: "html/account.ejs" }).render(template);
					$("#content").hide().html(html).fadeIn();
					$("#new_bookmark").live("click", function() {
						currentUser.createMemory($("form#new_memory").serialize());
						return false;
					});
					var memories = new window.Memories();
					memories.setHandlers();
					document.getElementById("exit").onclick = currentUser.logout;
				});
			}
        	});
		
		/* registration */
		
		var $registration = $("#registration-div"),
			$authorization = $("#authorization-div");
			
		$registration.load("html/registration.html", function() { 
			$("#registration").ajaxForm(function(data) {
				$("#reg-error-message").html(data.message);
				if(data.result) {
					setTimeout(function() {
						$registration.hide();
						$authorization.fadeIn();
					}, 1500);
				}
	       		});
		});
			
		$("#registration-link").live("click", function() {
			$authorization.hide();
			$registration.show();
			return false;
		});
		
		$("#back").live("click", function() {
			$authorization.show();
			$registration.hide();
			return false;
		});
		
	});
	
});