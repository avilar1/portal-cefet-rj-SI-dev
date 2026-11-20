const https = require("https");
https.get("https://cdn.jsdelivr.net/npm/frappe-gantt@0.6.1/dist/frappe-gantt.min.js", (r) => {
	let d = "";
	r.on("data", (c) => (d += c));
	r.on("end", () => {
		const i = d.indexOf("class l{constructor"); // Bar class often minified
		console.log("l class", i);
		const j = d.indexOf("this.compute_x");
		console.log(d.slice(j, j + 800));
		const k = d.indexOf("compute_x(){");
		console.log("cx", d.slice(k, k + 500));
		const m = d.indexOf("get_step_dates");
		console.log("dates helper", d.slice(m, m + 200));
	});
});
