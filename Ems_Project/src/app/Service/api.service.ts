import { Global } from '../Shared/Global';
import { Injectable } from '@angular/core';
import { Http, Response, Headers, RequestOptions, URLSearchParams } from '@angular/http';


import { Observable } from 'rxjs/Rx';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/do';
import 'rxjs/add/operator/catch';
import 'rxjs/add/observable/throw';
import { constants } from 'os';

@Injectable()
export class APIService {

    baseURL: string = Global.BASE_URL;
    constructor(private _http: Http) { }

    get(url: string): Observable<any> {
     
        return this._http.get(this.baseURL + url)
            .map((response: Response) => <any>response.json())
            .catch(this.handleError);
    }
    
    post(url: string, model: any): Observable<any> {
        //  let body = JSON.stringify(model);
          let headers = new Headers();
          headers.append('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
          let body = 'data=' + JSON.stringify(model);
          let options = new RequestOptions({ headers: headers });
          return this._http.post(this.baseURL + url, body, options)
              .map((response: Response) => <any>response.json())
              .catch(this.handleError);
      }

    put(url: string, id: number, model: any): Observable<any> {
        let body = JSON.stringify(model);
        let headers = new Headers({ 'Content-Type': 'application/json' });
        let options = new RequestOptions({ headers: headers });
        return this._http.put(this.baseURL + url + '/' + id, body, options)
            .map((response: Response) => <any>response.json())
            .catch(this.handleError);
    }

    delete(url: string, id: string): Observable<any> {
        let headers = new Headers({ 'Content-Type': 'application/json' });
        let options = new RequestOptions({ headers: headers });
        return this._http.delete(this.baseURL + url + id, options)
            .map((response: Response) => <any>response.json())
            .catch(this.handleError);
    }

    upload(url: string, model: any): Observable<any> {
        let body = model;
        // let headers = new Headers({ 'Content-Type': 'multipart/form-data' });
        // headers.append('enctype','multipart/form-data');
        //let headers = new Headers();        
        let headers = new Headers();
        //headers.append('Content-Type','application/x-www-form-urlencoded');        
        let options = new RequestOptions({ headers: headers });
        return this._http.post(this.baseURL + url, body, options)
            .map((response: Response) => <any>response.json())
            .catch(this.handleError);
    }

    private handleError(error: any) {
        let errMsg = (error.message) ? error.message :
            error.status ? `${error.status} - ${error.statusText}` : 'Server error';
        return Observable.throw(errMsg);
    }

}