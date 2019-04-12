import { Component, OnInit, NgZone } from '@angular/core';
import { trigger, transition, style, state, animate } from '@angular/animations';
import { AlertService } from '../../_services/alert.service';
@Component({
  selector: 'alert',
  templateUrl: './alert.component.html',
  styleUrls: ['./alert.component.css'],
})
export class AlertComponent implements OnInit {

  private status: boolean;
  private type: string;
  private message: string;

  constructor(
    private alertService: AlertService,
    private zone: NgZone
  ) {}

  ngOnInit() {
    this.alertService.settings.subscribe(
      (data) => {
        this.type = data.type;
        this.message = data.message;
        this.status = true;
        this.zone.runOutsideAngular(() =>
          setTimeout(() =>
            this.zone.run(() =>
              this.status = false
            ), 5000
          )
        )
      }
    );
  }

  resolve() {
    this.status = false;
  }
}