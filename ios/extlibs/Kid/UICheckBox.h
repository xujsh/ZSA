//
//  UICheckBox.h
//  ChinesePokerHD
//
//  Created by kidliuxu on 13-9-24.
//  Copyright (c) 2013年 Fans Media Co. Ltd. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "UICheckBoxDelegate.h"
#import "UIColorFormat.h"

@interface UICheckBox : UIButton
{
    //UIImage *onImg;
    //UIImage *offImg;
    //id<UICheckBoxDelegate> *myDelegate;
}

@property (nonatomic, retain) UILabel *checkLabel;
@property (nonatomic, assign) id<UICheckBoxDelegate> myDelegate;
@property (nonatomic) int labelOnColor;
@property (nonatomic) int labelOffColor;
@property (assign) BOOL isSelect;
//@property (nonatomic, retain) UIImage *offImg;

- (id)initWithCheckOnImg:(UIImage *) checkOnImg CheckOFFImg:(UIImage *) checkOFFImg;
- (id)initWithOnFile:(NSString *) onFileName OffFile:(NSString *) offFileName;
- (id)initWithOnFile:(NSString *) onFileName OffFile:(NSString *) offFileName labelStr:(NSString *)labelString onColor:(int)oncolorint offColor:(int)offcolorint;
- (id)initWithOnFile:(NSString *) onFileName OffFile:(NSString *) offFileName isSelect:(BOOL) tf callBack:(id<UICheckBoxDelegate>) delegate;
- (id)initWithOnFile:(NSString *) onFileName OffFile:(NSString *) offFileName labelStr:(NSString *)labelString isSelect:(BOOL) tf callBack:(id<UICheckBoxDelegate>) delegate;

- (void) setLabelStyle:(UIFont *)setfont Color:(UIColor *) setcolor alignment:(NSTextAlignment) textAlgnment;
- (void) setLabelFont:(UIFont *)setfont;
- (void) setLabelColor:(UIColor *)setcolor;
- (void) setLabelAlignment:(NSTextAlignment)textAlgnment;
- (void) addVelueChangeDelegate:(id<UICheckBoxDelegate>) delegate;
- (void) setCheckBoxIsSelected:(BOOL)tf;

@end
