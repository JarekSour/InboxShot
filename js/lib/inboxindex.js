$('document').ready(function() {
	$.post('core/mid/midIndex.php',{
		opt:'grafic',typ:'fid'
	},function(z,x){
		$("#loaderFI").fadeOut();
		obj = JSON.parse(z);
		$("#apfi").html(obj.aper+"<br>aperturas");
		$("#profi").html(obj.envi);
		$(".chart1").data('easyPieChart').update(obj.porce);
	});
	
	$.post('core/mid/midIndex.php',{
		opt:'grafic',typ:'ven'
	},function(z,x){
		$("#loaderVE").fadeOut();
		obj = JSON.parse(z);
		$("#apve").html(obj.aper+"<br>aperturas");
		$("#prove").html(obj.envi);
		$(".chart2").data('easyPieChart').update(obj.porce);
	});
	
	$.post('core/mid/midIndex.php',{
		opt:'grafic',typ:'inv'
	},function(z,x){
		$("#loaderIN").fadeOut();
		obj = JSON.parse(z);
		$("#apin").html(obj.aper+"<br>aperturas");
		$("#proin").html(obj.envi);
		$(".chart3").data('easyPieChart').update(obj.porce);
	});	
});

$(function() {
	$('.chart1').easyPieChart({
		animate: 2000,
		scaleLength:10,
        size:175,
		lineWidth:20,
		lineCap: 'butt',
        barColor:function(percent) {
				    percent /= 100;
				    return "rgb(" + Math.round(255 * (1-percent)) + ", " + Math.round(200 * percent) + ", 0)";
			},
		onStep: function(from, to, percent) {
			$(this.el).find('.percent').text(Math.round(percent));
		}
	});
	
	$('.chart2').easyPieChart({
		animate: 2000,
		scaleLength:10,
        size:175,
		lineWidth:20,
		lineCap: 'butt',
        barColor:function(percent) {
				    percent /= 100;
				    return "rgb(" + Math.round(255 * (1-percent)) + ", " + Math.round(200 * percent) + ", 0)";
			},
		onStep: function(from, to, percent) {
			$(this.el).find('.percent').text(Math.round(percent));
		}
	});
	
	$('.chart3').easyPieChart({
		animate: 2000,
		scaleLength:10,
        size:175,
		lineWidth:20,
		lineCap: 'butt',
        barColor:function(percent) {
				    percent /= 100;
				    return "rgb(" + Math.round(255 * (1-percent)) + ", " + Math.round(200 * percent) + ", 0)";
			},
		onStep: function(from, to, percent) {
			$(this.el).find('.percent').text(Math.round(percent));
		}
	});
});
