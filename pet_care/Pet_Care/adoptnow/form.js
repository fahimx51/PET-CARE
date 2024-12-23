document.addEventListener("DOMContentLoaded", function() {
    const petTypeElement = document.getElementById("petType");
    const breedElement = document.getElementById("breed");
    const ageElement = document.getElementById("age");

    const breeds = {
        cat: ["Desi", "Persian", "Other"],
        dog: ["Desi", "Golden Retriever", "Other"],
        bird: ["Parrots", "Pigeon", "Other"],
        other: ["Other"]
    };

    const populateBreeds = (type) => {
        breedElement.innerHTML = "";
        breeds[type].forEach(breed => {
            const option = document.createElement("option");
            option.value = breed.toLowerCase();
            option.textContent = breed;
            breedElement.appendChild(option);
        });
    };

    petTypeElement.addEventListener("change", (event) => {
        populateBreeds(event.target.value);
    });

    // Populate age dropdown
    for (let i = 6; i <= 120; i += 6) {
        const option = document.createElement("option");
        option.value = i;
        option.textContent = `${i} months`;
        ageElement.appendChild(option);
    }

    // Initial population
    populateBreeds(petTypeElement.value);
});
