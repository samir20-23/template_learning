import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MeanComponent } from './mean.component';

describe('MeanComponent', () => {
  let component: MeanComponent;
  let fixture: ComponentFixture<MeanComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [MeanComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(MeanComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
