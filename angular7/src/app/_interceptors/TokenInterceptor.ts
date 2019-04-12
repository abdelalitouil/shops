import { Injectable } from '@angular/core';
import { HttpRequest, HttpHandler, HttpEvent, HttpInterceptor } from '@angular/common/http';
import { Observable } from 'rxjs';
import { UserService } from '../_services/user.service';

@Injectable()
export class TokenInterceptor implements HttpInterceptor {

    constructor(private userService: UserService) { }

    intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
        let user = this.userService.userObject;
        if (user && user.token) {
            request = request.clone({
                setHeaders: {
                    "X-AUTH-TOKEN": user.token,
                    'Content-Type': 'application/json'
                }
            });
        }
        return next.handle(request);
    }
}