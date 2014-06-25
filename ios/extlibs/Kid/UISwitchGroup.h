//
//  UISwitchGroup.h
//  ChinesePokerHD
//
//  Created by kidliuxu on 13-12-3.
//  Copyright (c) 2013年 Fans Media Co. Ltd. All rights reserved.
//

#import "UIViewGroup.h"
#import "KidUISwitch.h"

@protocol UISwitchGroupDelegate

- (void) didGroupSwitchChanged:(KidUISwitch *)uiSwitch;

@end

@interface UISwitchGroup : UIViewGroup <KidUISwitchDelegate>

@property (nonatomic, assign) id<UISwitchGroupDelegate> myDelegate;

-(void) setDelegate:(id<UISwitchGroupDelegate>) delegate;

@end
