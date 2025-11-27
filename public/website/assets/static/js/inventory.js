"use strict";

import { generateInventoryItemTemplate } from "./templateGenerator.js";

fetch("inventory.json")
  .then((response) => response.json())
  .then((data) => {
    const inventory = data;
    for (let i = 0; i < inventory.length; i++) {
      const inventoryDetails = inventory[i];
      //   console.log(inventoryDetails);

      generateInventoryItemTemplate(
        inventoryDetails.imagePath,
        inventoryDetails.name,
        inventoryDetails.price,
        inventoryDetails.features,
        inventoryDetails.gallery
      );
    }
  });
