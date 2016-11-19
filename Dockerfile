FROM php:7.1-rc-cli
COPY . /usr/src/falx-generators
WORKDIR /usr/src/falx-generators
CMD [ "php", "./observed_generator_example.php" ]
