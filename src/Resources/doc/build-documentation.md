# Build documentation

You can read files in the folder `src/Resources/doc` or you can compile the documentation with MkDocs.

## MkDocs

* Install Python 2.7 and Pip 1.5
* Install MkDocs: `pip install mkdocs`
* Install pymdown-extension: `pip install pymdown-extensions`
* Compile the doc: `mkdocs build`
* Preview the doc: `mkdocs serve` at <http://127.0.0.1:8000>

## Deploy to gh-pages

Documentation is deployed here: <https://mailjet.github.io/laravelmailjet/>

In order to deploy a new version of documentation: `mkdocs gh-deploy`
