# Garagist.Mjml

[![Latest stable version]][packagist] [![GitHub stars]][stargazers] [![GitHub watchers]][subscription] [![GitHub license]][license] [![GitHub issues]][issues] [![GitHub forks]][network]

[MJML] is a markup language to build responsive email templates by providing a semantic syntax and a rich standard component library.

## Usage

You can use this package with the offical API from [MJML] or with [Docker] and the [MJML image from Adrian Rudnik].

### Use with the offical API from MJML

To use it with the MJML API, set `apiEndpoint` to `true`. You have also to set the `applicationID` and the `secretKey`. If you don't want to use the enviroments variables, you can simply over them in your `Settings.yaml` file.

```yaml
Garagist:
  Mjml:
    apiEndpoint: true
    applicationID: "%env:MJML_API_APPLICATION_ID%"
    secretKey: "%env:MJML_API_SECRET_KEY%"
```

### Use with docker

Simply set the enviroment variable `MJML_API_ENDPOINT`, or set it in your `Settings.yaml`:

```yaml
Garagist:
  Mjml:
    apiEndpoint: "mjml:80"
```

### Development with ddev

If you use [ddev] for development you can use following configuration:

```yaml
version: "3.6"
services:
  mjml:
    container_name: ddev-${DDEV_SITENAME}-mjml
    hostname: ${DDEV_SITENAME}-mjml
    image: adrianrudnik/mjml-server
    labels:
      com.ddev.site-name: ${DDEV_SITENAME}
      com.ddev.approot: $DDEV_APPROOT
    environment:
      - HTTP_EXPOSE=8080
      - CORS=*
      - MJML_KEEP_COMMENTS=true
      - MJML_VALIDATION_LEVEL=strict
      - MJML_MINIFY=false
      - MJML_BEAUTIFY=true
      - HEALTHCHECK=false
```

After that, your MJML endpoint is something like `ddev-DDEV_SITENAME-mjml:80`

[packagist]: https://packagist.org/packages/garagist/mjml
[latest stable version]: https://poser.pugx.org/garagist/mjml/v/stable
[github issues]: https://img.shields.io/github/issues/Garagist/Garagist.Mjml
[issues]: https://github.com/Garagist/Garagist.Mjml/issues
[github forks]: https://img.shields.io/github/forks/Garagist/Garagist.Mjml
[network]: https://github.com/Garagist/Garagist.Mjml/network
[github stars]: https://img.shields.io/github/stars/Garagist/Garagist.Mjml
[stargazers]: https://github.com/Garagist/Garagist.Mjml/stargazers
[github license]: https://img.shields.io/github/license/Garagist/Garagist.Mjml
[license]: LICENSE
[github watchers]: https://img.shields.io/github/watchers/Garagist/Garagist.Mjml.svg
[subscription]: https://github.com/Garagist/Garagist.Mjml/subscription
[mjml]: https://mjml.io
[mjml image from adrian rudnik]: https://hub.docker.com/r/adrianrudnik/mjml-server
[docker]: https://www.docker.com
[ddev]: https://ddev.com/
