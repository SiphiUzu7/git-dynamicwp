PLUGIN_FILE_NAME:= "hostinger-easy-onboarding.zip"

PHONY: clean-release
clean-release:
	@echo "Cleaning release file"
	rm -rf ./build/hostinger-easy-onboarding*
	rm -f ./build/hostinger-easy-onboarding*.zip

PHONY: build-release
build-release: clean-release
	@echo "Building release:" $(PLUGIN_FILE_NAME)\
	"Compiling assets:"\
	&& composer config --global github-oauth.github.com "${HOSTINGER_GITHUB_TOKEN}" \
	&& composer install --no-dev\
	&& npm install\
	&& npm run prod\
	&& PLUGIN_NAME=$(PLUGIN_FILE_NAME)\
	&& composer install -o --no-dev\
	&& cd ./build && mkdir hostinger-easy-onboarding \
	&& rsync -r --exclude-from='../BUILDEXCLUDE' ../* hostinger-easy-onboarding \
	&& zip --verbose -r $$PLUGIN_NAME hostinger-easy-onboarding/* \
	&& rm -rf hostinger-easy-onboarding
