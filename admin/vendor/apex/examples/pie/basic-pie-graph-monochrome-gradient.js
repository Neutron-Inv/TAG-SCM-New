var options = {
	chart: {
		width: 400,
		type: 'pie',
	},
	series: [25, 15, 44, 55, 41, 17],
	labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
	fill: {
		type: 'gradient',
	},
	theme: {
		monochrome: {
			enabled: true,
			colors: ['#d44843', '#bf870a', '#8e639c', '#00887A'],
		}
	},
	title: {
		text: "Weekly Sales",
	},
	responsive: [{
		breakpoint: 480,
		options: {
			chart: {
				width: 200
			},
			legend: {
				position: 'bottom'
			}
		}
	}],
	stroke: {
		width: 0,
	},
}
var chart = new ApexCharts(
	document.querySelector("#basic-pie-graph-monochrome-gradient"),
	options
);
chart.render();


