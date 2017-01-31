# Get ApiGen.phar
wget http://www.apigen.org/apigen.phar

# Generate Api
php apigen.phar generate -s StoreCore -d ../gh-pages --template-theme bootstrap
cd ../gh-pages

# Set identity
git config --global user.email "no-reply@storecore.io"
git config --global user.name "storecorebot"

# Add branch
git init
git remote add origin https://${GH_TOKEN}@github.com/storecore/api.git > /dev/null
git checkout -B gh-pages

# Push generated files
git add .
git commit -m "API documentation updated"
git push origin gh-pages -fq > /dev/null
