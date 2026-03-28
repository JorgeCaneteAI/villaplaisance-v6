dev:
	php -S localhost:8000 -t public

push:
	git push

deploy:
	@read -p "Message de commit : " msg; \
	git add -A && git commit -m "$$msg" && git push

open:
	open https://vp.villaplaisance.fr
