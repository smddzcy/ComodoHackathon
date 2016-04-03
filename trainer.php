<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Trainer</title>
	<link rel="stylesheet" href="https://cdn.rawgit.com/twbs/bootstrap/v4-dev/dist/css/bootstrap.css">
	<style>
		.card-text {
			font-size: 0.8rem !important
		}
	</style>
</head>
<body class="text-xs-center">

	<div class="page-header">
		<h1>
			<small>Trainer</small>
		</h1>
	</div>

	<div id="mails">
	</div>

	<script src="//code.jquery.com/jquery.js"></script>
	<script src="https://cdn.rawgit.com/twbs/bootstrap/v4-dev/dist/js/bootstrap.js"></script>
	<script>
		$(document).ready(function () {
			var mailsField = $("#mails");

			function train(subj, cont, type) {
				$.ajax({
					url: 'http://localhost/ComodoHackathon/AjaxHandler.php',
					type: 'POST',
					dataType: 'json',
					async: false,
					data: {
						function: "train",
						data: {subject: subj, content: cont, type: type}
					},
					success: function (ret) {
						console.log(ret);
					}
				});
			}

			function getMails(count) {
				$.ajax({
					url: 'http://localhost/ComodoHackathon/AjaxHandler.php',
					type: 'POST',
					dataType: 'json',
					async: false,
					data: {
						function: 'getUntrainedMails',
						data: {count: count}
					},
					success: function (returnData) {
						for (var i in returnData) {
							mailsField.append('<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="padding-top:5px;padding-bottom:5px;">' +
								'<div class="card text-xs-center">' +
								'<h6 class="card-title">' + returnData[i]['subject'] + '</h6>' +
								'<p class="card-text">' + returnData[i]['content'] + '</p>' +
								'<a href="#" class="btn btn-primary btn-sm">SPAM</a>' +
								'<a href="#" class="btn btn-primary btn-sm">PERSONAL</a>' +
								'<a href="#" class="btn btn-primary btn-sm">PROMOTION</a>' +
								'<a href="#" class="btn btn-primary btn-sm">SOCIAL</a>' +
								'<a href="#" class="btn btn-danger btn-sm">X</a>' +
								'</div>' +
								'</div>');
						}
					}
				});
			}

			getMails(10);
			$('body').on('click', '.btn', function (el) {
				var selection = $(this).html();
				var subject = $(this).parent().find(".card-title").html();
				var content = $(this).parent().find(".card-text").html();
				$(this).parent().parent().html("");
				if(selection != "X"){
					console.log(selection);	
					train(subject, content, selection);
				}
				getMails(1);
			});
		});
	</script>
</body>
</html>