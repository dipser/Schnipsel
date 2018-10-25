/**
 * fetch data.
 */

export default (urlpath, urlparams) => {

  let url = new URL(urlpath);
  Object.keys(urlparams).forEach(key => url.searchParams.append(key, urlparams[key]));

  return fetch(url)
  //fetch({url:url, method:'get'})
  .then((resp) => resp.json())
  /*.then(function(data) {
    console.log(data);
    return data;
  })*/
  .catch(function(error) {
    console.log(error);
  });
  
}
