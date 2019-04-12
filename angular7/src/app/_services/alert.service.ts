import { Injectable } from '@angular/core';
import { Subject } from 'rxjs';
import { Alert } from '../_models/alert'; 

@Injectable()
export class AlertService {
  settings = new Subject<Alert>()
  constructor() { }
  create(
    type: string, message: string){
    this.settings.next({
      type,
      message
    });
  }
}