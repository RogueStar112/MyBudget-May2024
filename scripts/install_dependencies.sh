#!/bin/bash

# Install Bootstrap and jQuery using npm
npm install bootstrap jquery popper.js

# Optionally, copy Bootstrap's required files to the public directory
# You may need to adjust the paths based on your project structure
mkdir -p public/css public/js
cp node_modules/bootstrap/dist/css/bootstrap.min.css public/css/
cp node_modules/bootstrap/dist/js/bootstrap.min.js public/js/
cp node_modules/jquery/dist/jquery.min.js public/js/
cp node_modules/popper.js/dist/umd/popper.min.js public/js/
