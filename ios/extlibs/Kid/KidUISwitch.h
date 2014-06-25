//
//  KidUISwitch.h
//  ChinesePokerHD
//
//  Created by kidliuxu on 13-11-18.
//  Copyright (c) 2013年 Fans Media Co. Ltd. All rights reserved.
//

#import <UIKit/UIKit.h>

@protocol KidUISwitchDelegate

- (void) didKidUISwitchValeuChange:(id)sender isSWitch:(BOOL) switchValue;

@end

@interface KidUISwitch : UIView
{
    int btnWidth;
    int bgWidth;
    int btnHeight;
    int bgHeigth;
}

@property (retain, nonatomic) UIButton *btn;
@property (retain, nonatomic) UILabel *onLabel;
@property (retain, nonatomic) UILabel *offLabel;
@property (nonatomic, assign) id<KidUISwitchDelegate> myDelegate;
@property (assign) BOOL isYES;

-(id)initwithSliderBtnFile:(NSString *) sliderBtnFile bgImgFile:(NSString *) bgImgFile defaultSelect:(BOOL) defaultType;
-(id)initwithSliderBtnFile:(NSString *) sliderBtnFile bgImgFile:(NSString *) bgImgFile onString:(NSString *)onStr offString:(NSString *) offStr defaultSelect:(BOOL) defaultType;
-(void)setCallBack: (id<KidUISwitchDelegate>) callBack;

@end
