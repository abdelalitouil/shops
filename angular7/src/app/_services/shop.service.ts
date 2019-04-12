import { Injectable } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { Observable } from "rxjs";
import { environment } from "./../../environments/environment";
import { Alert } from "../_models/alert";
import { UserService } from "./user.service";

@Injectable({
    providedIn: "root"
})
export class ShopService {

    constructor(private http: HttpClient, private userService: UserService) {
        this.init();
    }

    async init() { }

    // Return the list of nearby shops
    retrieveShops(): Observable<any> {
        return this.http
            .get<any>(
                environment.apiUrl + "/api/shop/list"
            );
    }

    // Return the list of preferred shops
    retrievePreferredShops(): Observable<any> {
        return this.http
            .get<any>(
                environment.apiUrl + "/api/shop/preferredList"
            );
    }

    // Add a shop to the preferred list.
    like(id: number): Observable<Alert> {
        return this.http
            .get<Alert>(
                environment.apiUrl + "/api/shop/" + id + "/like"
            );
    }

    // Hide a shop for 2 hours
    dislike(id: number): Observable<Alert> {
        return this.http
            .get<Alert>(
                environment.apiUrl + "/api/shop/" + id + "/dislike"
            );
    }

    // Remove a shop from the preferred list
    remove(id: number): Observable<Alert> {
        return this.http
            .delete<Alert>(
                environment.apiUrl + "/api/shop/" + id + "/remove"
            );
    }
}
