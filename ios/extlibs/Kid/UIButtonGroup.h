//
//  UIButtonGroup.h
//  ChinesePokerHD
//
//  Created by kidliuxu on 13-11-14.
//  Copyright (c) 2013年 Fans Media Co. Ltd. All rights reserved.
//

#import "UIViewGroup.h"

@protocol UIButtonGroupDelegate

- (void) didUIButtonClicked:(UIButton *)btn;

@end

@interface UIButtonGroup : UIViewGroup

@property (nonatomic, assign) id<UIButtonGroupDelegate> myDelegate;
-(void) setDelegate:(id<UIButtonGroupDelegate>) delegate;

@end
