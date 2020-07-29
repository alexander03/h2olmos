	// The autoComplete.js Engine instance creator
var autoCompletejs = new autoComplete({
	data: {
		src: async () => {
			// Loading placeholder text
			document
				.querySelector(".ua_id")
				.setAttribute("placeholder", "Loading...");
			// Fetch External Data Source
			const headers = new Headers();
			headers.append('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
			const config = {
	        	headers,
	        	method:'GET'
      		};
			const source = await fetch(
				"/equipo/uas" , config
			);
			const data = await source.json();
			// Post loading placeholder text
			// Returns Fetched data
			return data;
		},
		key: [ "descripcion"],
		cache: false
	},
	sort: (a, b) => {
		if (a.match < b.match) return -1;
		if (a.match > b.match) return 1;
		return 0;
	},
	selector: ".ua_id",
	threshold: 3,
	debounce: 0,
	searchEngine: "strict",
	highlight: true,
	maxResults: 5,
	resultsList: {
		render: true,
		container: source => {
      source.setAttribute("id", "autoComplete_list");
		},
		destination: document.querySelector(".ua_id"),
		position: "afterend",
		element: "ul"
	},
	resultItem: {
		content: (data, source) => {
      source.innerHTML = data.match;
		},
		element: "li"
	},
	noResults: () => {
		const result = document.createElement("li");
		result.setAttribute("class", "no_result");
		result.setAttribute("tabindex", "1");
		result.innerHTML = "Sin resultados";
		document.querySelector("#autoComplete_list").appendChild(result);
	},
	onSelection: feedback => {
		const selection = feedback.selection.value.codigo;
		// Render selected choice to selection div
		document.querySelector(".selection").innerHTML = selection;
		// Clear Input
		document.querySelector(".ua_id").value = "";
		// Change placeholder with the selected value
		document
			.querySelector(".ua_id").value = selection;
		// Concole log autoComplete data feedback
		console.log(feedback);
	}
});



// Toggle event for search input
// showing & hidding results list onfocus / blur
["focus", "blur"].forEach(function(eventType) {
  const resultsList = document.querySelector("#autoComplete_list");

  document.querySelector(".ua_id").addEventListener(eventType, function() {
    // Hide results list & show other elemennts
    if (eventType === "blur") {
      resultsList.style.display = "none";
    } else if (eventType === "focus") {
      // Show results list & hide other elemennts
      resultsList.style.display = "block";
    }
  });
});