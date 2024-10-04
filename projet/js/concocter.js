$(document).ready(function () {

    let cart = {};

    document.querySelector("#btn-confirmation").addEventListener('click', () => {

        if (Object.keys(cart).length <= 0)
            return;

        let potions = [];
        for (keyPot in cart) {
            potions.push({
                id: keyPot,
                quantity: cart[keyPot].quantity
            });
        }

        $.ajax({
            url: 'concocterConfirmation.php',
            method: 'POST',
            data: {
                potions: potions,
            },
            success: function(data) {
                $.ajax({
                    url: 'concocterAcheter.php',
                    method: 'POST',
                    data: {
                        potions: potions,
                    },
                    success: function(data) {
                        window.location.replace("./inventaire.php");
                    }
                })
            },
            error: function(data) {
                document.querySelector("#error-concocter").innerHTML = data.responseText.split("°")[1];
            }
        });
    });
    
    document.querySelectorAll(".recette-quantity").forEach( txtBox => {
        txtBox.addEventListener('keydown', e => {

            if (!isNaN(e.key) && txtBox.textContent.length >= 3) {
                e.preventDefault();
            }

            if (isNaN(e.key) && e.key !== 'Backspace' && e.key !== 'ArrowLeft' && e.key !=='ArrowRight') {
                e.preventDefault();
            }
        });

        txtBox.onblur = () => {
            
            if (txtBox.textContent.length < 1) {
                txtBox.textContent = "0";
            }

            let idPotion = txtBox.getAttribute("idPotion");
            let quantity = parseInt(txtBox.textContent);
            update(idPotion, quantity);
        }
    });

    document.querySelectorAll(".recette-btn-add").forEach( btn => {
        let idPotion = btn.getAttribute("idPotion");
        let panier_quantity = document.querySelector("#recette-quantity-" + idPotion);

        btn.addEventListener("click", () => {
            let quantity = parseInt(panier_quantity.textContent) 
            let new_quantity =  (quantity < 100) ? quantity + 1 : 999;
            
            update(idPotion, new_quantity);
            btn.setAttribute("quantity", new_quantity);
            panier_quantity.textContent = new_quantity;
        });
    });

    document.querySelectorAll(".recette-btn-remove").forEach( btn => {
        let idPotion = btn.getAttribute("idPotion");
        let panier_quantity = document.querySelector("#recette-quantity-" + idPotion);

        btn.addEventListener("click", () => {
            let quantity = parseInt(panier_quantity.textContent) 
            let new_quantity = (quantity > 0) ? quantity - 1 : 0;
            
            update(idPotion, new_quantity);
            btn.setAttribute("quantity", new_quantity);
            panier_quantity.textContent = new_quantity;
        });
    });

    function renderCart() {
        let elemsCart = document.querySelector(".potions-cart-elements");
        let potionsCart = document.querySelector(".potions-cart-potions");

        potionsCart.innerHTML = "";
        elemsCart.innerHTML = "";

        for (keyPot in cart) {

            let nodePotion = document.createElement("div");
            nodePotion.classList.add("potion-cart-item");
            nodePotion.classList.add("select-none");
            
            let imgPotion = document.createElement("img");
            imgPotion.classList.add("recette-img");
            imgPotion.classList.add("select-none");
            imgPotion.src = cart[keyPot].src;
            imgPotion.title = cart[keyPot].title;
            nodePotion.append(imgPotion);

            let countPotion = document.createElement("span");
            countPotion.textContent = cart[keyPot].quantity;
            countPotion.classList.add("cart-item-count");
            nodePotion.append(countPotion);

            potionsCart.append(nodePotion)
        }

        let elements = [];
        
        for (keyPot in cart) {
            let elems = cart[keyPot].elements;
            for (keyElem in elems) {
                if (elements[elems[keyElem].id] == undefined) {
                    elements[elems[keyElem].id] = structuredClone(elems[keyElem]);
                }
                else {
                    elements[elems[keyElem].id].quantity += elems[keyElem].quantity;
                }
            }
        }
            
        for (keyElem in elements) {

            let nodeElem = document.createElement("div");
            nodeElem.classList.add("elem-cart-item");
            nodeElem.classList.add("select-none");
            
            let imgElem = document.createElement("img");
            imgElem.classList.add("recette-img");
            imgElem.classList.add("select-none");
            imgElem.src = elements[keyElem].src;
            imgElem.title = elements[keyElem].title;
            nodeElem.append(imgElem);

            let countElem = document.createElement("span");
            countElem.textContent = elements[keyElem].quantity;
            countElem.classList.add("cart-item-count");
            nodeElem.append(countElem);

            elemsCart.append(nodeElem)
        }
    }

    function update(idPotion, quantity) {        

        if (quantity > 0) {
            let potion = document.querySelector(".potions-list .potion-img-" + idPotion)
            let elems = document.querySelectorAll(".potions-list .elem-img-" + idPotion)
            let elements = [];

            elems.forEach( e => {
                elements.push({
                    id: e.getAttribute("idElement"),
                    title: e.getAttribute("title"),
                    src: e.getAttribute("src"),
                    quantity: quantity
                });
            });

            cart[idPotion] = {
                quantity: quantity,
                title: potion.getAttribute("title"),
                src: potion.getAttribute("src"),
                elements: elements
            };
        }
        else {
            delete cart[idPotion];
        }

        renderCart();
    }
});