<script>
    var currentTab = 0; // Current tab is set to be the first tab (0)
    showTab(currentTab); // Display the current tab
    var formData = {};
    function showTab(n) {
        
        // This function will display the specified tab of the form ...
        var x = document.getElementsByClassName("tab");
        x[n].style.display = "block";
        // ... and fix the Previous/Next buttons:
        if (currentTab) {
            var cl = document.getElementsByClassName("step")[currentTab];
        }
        if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            
            document.getElementById("prevBtn").style.display = "inline";
        }

        if (n == (x.length - 1)) {
            document.getElementById("prevBtn").style.display = "none";
            document.getElementById("nextBtn").style.display = "none";

            var btn = document.getElementById("nextBtn");
            setTimeout(() => {
                btn.setAttribute('type', 'submit');
                btn.click(); // simulateur de soumission (si nécessaire)
            }, 2000);
            // const formElem = document.querySelector("form");

            // // submit handler

            // formElem.addEventListener("submit", (e) => {
            // // on form submission, prevent default
            //     e.preventDefault();
            //     const formData = new FormData(formElem);
            //     console.log(formData);
            // });
        } else {
            if (n == (x.length - 2)) {
                document.getElementById("nextBtn").innerHTML = "Publier l'annonce";
            }else{
                document.getElementById("nextBtn").innerHTML = 'Suivante <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"><path fill="#26e3c0" fill-rule="evenodd" d="M13.47 5.47a.75.75 0 0 1 1.06 0l6 6a.75.75 0 0 1 0 1.06l-6 6a.75.75 0 1 1-1.06-1.06l4.72-4.72H4a.75.75 0 0 1 0-1.5h14.19l-4.72-4.72a.75.75 0 0 1 0-1.06" clip-rule="evenodd"/></svg>';
            }
        }
        // ... and run a function that displays the correct step indicator:
        fixStepIndicator(n)
    }
    function showSummary(formData) {
        console.log(formData.name);
        
        document.getElementById("resume_name").innerText = formData.name || "Non renseigné";
        document.getElementById("resume_montant").innerText = formData.montant || "Non renseigné";
        document.getElementById("resume_adresse").innerText = formData.adresse || "Non renseigné";
        document.getElementById("resume_date_disponibilite").innerText = formData.date_disponibilite || "Non renseigné";
        document.getElementById("resume_superficie").innerText = formData.superficie || "Non renseigné";
        document.getElementById("resume_chambres").innerText = formData.chambres || "Non renseigné";
        document.getElementById("resume_cuisines").innerText = formData.cuisines || "Non renseigné";
        document.getElementById("resume_salons").innerText = formData.salons || "Non renseigné";
        document.getElementById("resume_toillettes").innerText = formData.toillettes || "Non renseigné";
        document.getElementById("resume_description").innerText = formData.description || "Non renseigné";

    }
    function nextPrev(n) {
        if (n==1) {
            let comodites = document.getElementsByName("comodites[]");
            let comoditeList = [];
    
            comodites.forEach(input => comoditeList.push(input.value));
    
            formData.name = document.getElementById("name").value;
            formData.date_disponibilite = document.getElementById("date_disponibilite").value;
            formData.montant = document.getElementById("montant").value;
            formData.adresse = document.getElementById("ship-address").value;
            formData.superficie = document.getElementById("superficie").value;
            formData.description = document.getElementById("description").value;
            formData.chambres = document.getElementById("piece-Chambres").value;
            formData.cuisines = document.getElementById("piece-Cuisines").value;
            formData.salons = document.getElementById("piece-Salons").value;
            formData.toillettes = document.getElementById("piece-Toillettes").value;
            formData.url_video = document.getElementById("url_video").value;
            formData.visite_virtuelle = document.getElementById("visite_virtuelle").value;
            showSummary(formData);
        }

        // console.log(formData);
        $("input").removeClass("border-danger");
        // This function will figure out which tab to display
        var x = document.getElementsByClassName("tab");
        // Exit the function if any field in the current tab is invalid:
        if (n == 1 && !validateForm()) return false;
        // Hide the current tab:

        x[currentTab].style.display = "none";
        // Increase or decrease the current tab by 1:
        currentTab = currentTab + n;
        // if you have reached the end of the form... :
        if (currentTab >= x.length) {
            //...the form gets submitted:
            document.getElementById("regForm").submit();
            return false;
        }
        // Otherwise, display the correct tab:
        showTab(currentTab);
    }

    function validateForm() {
        // This function deals with validation of the form fields
        var x, y, i, valid = true;
        x = document.getElementsByClassName("tab");
        y = x[currentTab].getElementsByTagName("input");
        // A loop that checks every input field in the current tab:
        for (i = 0; i < y.length; i++) {
           if(y[i].getAttribute('required')!=null){
                // console.log(y[i].value);
                if (y[i].value == "") {
                // add an "invalid" class to the field:
                    y[i].className += " border-danger";
                    // and set the current valid status to false:
                    valid = false;
               }
           }
            // If a field is empty...
        }
        // If the valid status is true, mark the step as finished and valid:
        if (valid) {
            document.getElementsByClassName("step")[currentTab].className += " active";
        }
        return valid; // return the valid status
    }

    function fixStepIndicator(n) {
        // This function removes the "active" class of all steps...
        var i, x = document.getElementsByClassName("step");

        // for (i = 0; i < x.length; i++) {
        for (i = n; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active", "");
        }
        // for (i = 0; i > x.length; i++) {
        //     console.log('step',n);
        //     x[i].className = "active";
        // }
        //... and adds the "active" class to the current step:
        x[n].className += " active";
    }

</script>