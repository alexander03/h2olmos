const doSearchEquipo = () => {
    // The autoComplete.js Engine instance creator
    var autoCompletejs = new autoComplete({
        data: {
            src: async () => {
                // Loading placeholder text
                document
                    .querySelector(".js-equipo")
                    .setAttribute("placeholder", "Loading...");
       
                // Fetch External Data Source
                const headers = new Headers();
                headers.append('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
                const config = {
                    headers,
                    method:'GET'
                };
                  //Query
                const query = document.querySelector('.js-equipo').value;
                const source = await fetch(
                    `/equipo/search/${query}` , config
                );
                let data = await source.json();
                // Post loading placeholder text
                // Returns Fetched data
                return data;
            },
            key: [ "codigo"],
            cache: false
        },
        sort: (a, b) => {
            if (a.match < b.match) return -1;
            if (a.match > b.match) return 1;
            return 0;
        },
        selector: ".js-equipo",
        threshold: 1,
        debounce: 0,
        searchEngine: "strict",
        highlight: true,
        maxResults: 5,
        resultsList: {
            render: true,
            container: source => {
                source.setAttribute("id", "autoComplete_list_equipo");
                source.setAttribute("class", "u-search-ua__result");
            },
            destination: document.querySelector(".js-equipo"),
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
        onSelection: feedback => { //VA NUESTRA LOGICA
            const selection = feedback.selection.value;
            document.querySelector(".js-equipo").value = selection.codigo;
            document.querySelector(".js-ua-desc").innerText = selection.descripcion;
            // console.log(feedback);
        }
    });
    
    // Toggle event for search input
    // showing & hidding results list onfocus / blur
    ["focus", "blur"].forEach(function(eventType) {
      const resultsList = document.querySelector("#autoComplete_list");
    
      document.querySelector(".js-equipo").addEventListener(eventType, function() {
        // Hide results list & show other elemennts
        if (eventType === "blur") {
          resultsList.style.display = "none";
        } else if (eventType === "focus") {
          // Show results list & hide other elemennts
          resultsList.style.display = "block";
        }
      });
    });
};

